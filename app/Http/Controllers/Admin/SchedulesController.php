<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SchedulesExport;
use App\Http\Controllers\Controller;
use App\Models\Schedules;
use App\Models\Subjects;
use App\Models\Classes;
use App\Models\Teachers;
use App\Models\SchoolShift;
use App\Models\Classroom;
use App\Models\ClassSubject;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;


class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('keyword');

        $getAllTeachingSchedule = Schedules::with(['class', 'subject', 'teacher', 'room', 'schoolShift']);
        if ($request->filled('class_id')) {
            $getAllTeachingSchedule->where('class_id', $request->class_id);
        }
        if ($request->filled('subject_id')) {
            $getAllTeachingSchedule->where('subject_id', $request->subject_id);
        }
        if ($request->filled('teacher_id')) {
            $getAllTeachingSchedule->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('school_shift_id')) {
            $getAllTeachingSchedule->where('school_shift_id', $request->school_shift_id);
        }

        if (!empty($search)) {
            $getAllTeachingSchedule->where(function ($query) use ($search) {
                $query->whereHas('class', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('subject', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('schoolShift', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('teacher', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }
        $data = $getAllTeachingSchedule
            ->orderBy('schedule_date', 'asc')
            ->orderBy('school_shift_id', 'asc')
            ->get();

        $template = "admin.schedule.schedule.pages.index";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/subject.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];

        return view('admin.dashboard.layout', compact('template', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = "admin.schedule.schedule.pages.store";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/subject.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];
        $config['method'] = 'create';

        // Lấy dữ liệu cho form
        $classes = Classes::all();
        $subjects = Subjects::all();
        $teachers = Teachers::all();
        $schoolShifts = SchoolShift::where('status', 1)->get();
        $classrooms = Classroom::where('status', 1)->get();

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'classes',
            'subjects',
            'teachers',
            'schoolShifts',
            'classrooms'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        $schedule = new Schedules();
        $schedule->class_id = $data['class_id'];
        $schedule->subject_id = $data['subject_id'];
        $schedule->teacher_id = $data['teacher_id'];
        $schedule->room_id = $data['room_id'];
        $schedule->school_shift_id = $data['school_shift_id'];
        $schedule->schedule_date = $data['schedule_date'];
        $schedule->day_of_week = $data['day_of_week'];
        $schedule->created_by = session('user_id');
        $schedule->save();

        toastr()->success('Thêm lịch huấn luyện thành công');
        return redirect()->route('schedule.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = "admin.schedule.schedule.pages.store";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/subject.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];
        $config['method'] = 'edit';

        $schedule = Schedules::findOrFail($id);

        // Lấy dữ liệu cho form
        $classes = Classes::all();
        $subjects = Subjects::all();
        $teachers = Teachers::all();
        $schoolShifts = SchoolShift::where('status', 1)->get();
        $classrooms = Classroom::where('status', 1)->get();

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'schedule',
            'classes',
            'subjects',
            'teachers',
            'schoolShifts',
            'classrooms'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, string $id)
    {
        $data = $request->validated();

        $schedule = Schedules::findOrFail($id);
        $schedule->class_id = $data['class_id'];
        $schedule->subject_id = $data['subject_id'];
        $schedule->teacher_id = $data['teacher_id'];
        $schedule->room_id = $data['room_id'];
        $schedule->school_shift_id = $data['school_shift_id'];
        $schedule->schedule_date = $data['schedule_date'];
        $schedule->day_of_week = $data['day_of_week'];
        $schedule->updated_by = session('user_id');
        $schedule->save();

        toastr()->success('Cập nhật lịch huấn luyện thành công');
        return redirect()->route('schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->delete();

        toastr()->success('Xóa lịch huấn luyện thành công');
        return redirect()->route('schedule.index');
    }
    /**
     * Export schedules to Excel
     */
    public function export(Request $request)
    {
        $keyword = $request->get('keyword');
        return Excel::download(new SchedulesExport($keyword), 'danh_sach_lich_huan_luyen_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
