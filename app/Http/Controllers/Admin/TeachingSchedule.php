<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Schedules;
use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Subjects;
use App\Models\SchoolShift;
use App\Models\Classroom;
use App\Models\Major;
use App\Exports\TeachingSchedulesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class TeachingSchedule extends Controller
{

   public function index(Request $request)
{
    $template = "admin.teaching_schedule.teaching_schedule.pages.index";

    // Lấy từ khóa tìm kiếm
    $search = $request->input('keyword');
    $teacherId = $request->input('teacher_id');

    $config = [
        'css' => [
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            '/admin/css/teaching_schedule.css'
        ],
        'js' => [
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            '/admin/plugins/ckeditor/ckeditor.js',
            '/admin/plugins/ckfinder_2/ckfinder.js',
            '/admin/lib/finder.js',
            '/admin/lib/library.js',
        ]
    ];

    // Lấy danh sách giảng viên cho dropdown
    $teachers = Teachers::all();

    // Truy vấn chính
    $getAllTeachingSchedule = Schedules::select(
        'schedules.*',
        'classes.name as class_name',
        'subjects.name as subject_name',
        'teachers.name as teacher_name',
        'school_shifts.name as shift_name',
        'school_shifts.start_time',
        'school_shifts.end_time',
        'classrooms.name as room_name'
    )
        ->join('classes', 'schedules.class_id', '=', 'classes.id')
        ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
        ->leftJoin('class_subjects', 'schedules.class_subject_id', '=', 'class_subjects.id')
        ->leftJoin('teachers', 'class_subjects.teacher_id', '=', 'teachers.id')
        ->leftJoin('school_shifts', 'schedules.school_shift_id', '=', 'school_shifts.id')
        ->leftJoin('classrooms', 'schedules.room_id', '=', 'classrooms.id');

    // Nếu có từ khóa tìm kiếm
    if (!empty($search)) {
        $getAllTeachingSchedule->where(function ($query) use ($search) {
            $query->whereRaw("LOWER(classes.name) LIKE ?", ["%" . strtolower($search) . "%"])
                  ->orWhereRaw("LOWER(subjects.name) LIKE ?", ["%" . strtolower($search) . "%"])
                  ->orWhereRaw("LOWER(teachers.name) LIKE ?", ["%" . strtolower($search) . "%"]);
        });
    }

    // Nếu có filter theo giảng viên
    if (!empty($teacherId)) {
        $getAllTeachingSchedule->where('class_subjects.teacher_id', $teacherId);
    }



    // Giới hạn theo role (nếu là giáo viên)
    if (session('user_role') == 3) {
        $getAllTeachingSchedule->where('class_subjects.teacher_id', session('user_id'));
    }

    // Lấy tất cả dữ liệu cho lịch (không phân trang)
    $getAllTeachingSchedule = $getAllTeachingSchedule
        ->orderBy('schedules.schedule_date', 'ASC')
        ->orderBy('school_shifts.start_time', 'ASC')
        ->get();

    // Không cần format lại ngày vì đã lưu đúng format Y-m-d

    // Check if request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'schedules' => $getAllTeachingSchedule->toArray()
        ]);
    }
    
    return view('admin.dashboard.layout', compact(
        'template',
        'getAllTeachingSchedule',
        'config',
        'teachers',
        'teacherId'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = "admin.teaching_schedule.teaching_schedule.pages.store";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/teaching_schedule.css'
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
        $schoolShifts = SchoolShift::where('status', 1)->orderBy('id')->get();
        $classrooms = Classroom::where('status', 1)->get();
        $majors = Major::all();
        
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'classes',
            'subjects',
            'teachers',
            'schoolShifts',
            'classrooms',
            'majors'
        ));
    }

    /**
     * Prefill date into session then redirect to create form
     */
    public function prefillDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'nullable|integer|exists:classes,id',
            'subject_id' => 'nullable|integer|exists:subjects,id',
            'shift_name' => 'nullable|string|max:255',
        ]);
        session(['prefill_schedule_date' => $request->input('date')]);
        if ($request->filled('class_id')) session(['prefill_class_id' => (int) $request->class_id]);
        if ($request->filled('subject_id')) session(['prefill_subject_id' => (int) $request->subject_id]);
        if ($request->filled('shift_name')) session(['prefill_shift_name' => $request->input('shift_name')]);
        return redirect()->route('teaching_schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log dữ liệu được gửi
        Log::info('Store teaching schedule data:', $request->all());
        Log::info('Schedule date received:', ['date' => $request->schedule_date]);
        
        // Debug: Kiểm tra teacher_id cụ thể
        if (!$request->has('teacher_id') || empty($request->teacher_id)) {
            Log::error('Teacher ID is missing or empty!');
            return back()->withErrors(['teacher_id' => 'Vui lòng chọn giảng viên!'])->withInput();
        }
        
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'school_shift_id' => 'required|exists:school_shifts,id',
            'room_id' => 'required|exists:classrooms,id',
            'schedule_date' => 'required|date',
            'day_of_week' => 'required|string|max:255',
        ]);

        // Lưu ngày trực tiếp không cần chuyển đổi timezone vì đây là date field
        $scheduleDate = $request->schedule_date;
        Log::info('Schedule date to be saved:', ['date' => $scheduleDate]);

        // Business rule: A class can have at most one specific shift per day
        $duplicateShiftExists = Schedules::where('class_id', $request->class_id)
            ->where('schedule_date', $scheduleDate)
            ->where('school_shift_id', $request->school_shift_id)
            ->exists();
        if ($duplicateShiftExists) {
            toastr()->error('Không thể thêm vì ca học bị trùng trong ngày này.');
            return back()
                ->withErrors(['school_shift_id' => 'Lớp đã có ca này trong ngày đã chọn. Vui lòng chọn ca khác.'])
                ->withInput();
        }

        // Bảo đảm có class_subject phù hợp (class, subject, teacher)
        $classSubject = ClassSubject::firstOrCreate(
            [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ],
            [
                'student_count' => 0,
                'start_date' => $scheduleDate,
                'end_date' => $scheduleDate,
            ]
        );

        $schedule = Schedules::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'class_subject_id' => $classSubject->id,
            'school_shift_id' => $request->school_shift_id,
            'room_id' => $request->room_id,
            'schedule_date' => $scheduleDate,
            'day_of_week' => $request->day_of_week,
            'created_by' => session('user_id'),
        ]);

        Log::info('Schedule created successfully:', ['id' => $schedule->id, 'date' => $schedule->schedule_date]);
        
        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm lịch dạy thành công',
                'schedule' => $schedule
            ]);
        }
        
        toastr()->success('Thêm lịch dạy thành công');
        return redirect()->route('teaching_schedule.index', [
            'saved' => 1,
            'date' => $scheduleDate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $getEdit = Schedules::findOrFail($id);
        
        // Không cần format lại ngày vì đã lưu đúng format Y-m-d
        $template = "admin.teaching_schedule.teaching_schedule.pages.store";
        
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/teaching_schedule.css'
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
        
        // Lấy dữ liệu cho form
        $classes = Classes::all();
        $subjects = Subjects::all();
        $teachers = Teachers::all();
        $schoolShifts = SchoolShift::where('status', 1)->get();
        $classrooms = Classroom::where('status', 1)->get();
        
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'getEdit',
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
    public function update(Request $request, $id)
    {
        // Debug: Log dữ liệu được gửi
        Log::info('Update teaching schedule data:', $request->all());
        
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'school_shift_id' => 'required|exists:school_shifts,id',
            'room_id' => 'required|exists:classrooms,id',
            'schedule_date' => 'required|date',
            'day_of_week' => 'required|string|max:255',
        ]);

        // Lưu ngày trực tiếp không cần chuyển đổi timezone vì đây là date field
        $scheduleDate = $request->schedule_date;

        // Business rule: Avoid duplicate shift for class on same day (exclude current id)
        $duplicateShiftExists = Schedules::where('class_id', $request->class_id)
            ->where('schedule_date', $scheduleDate)
            ->where('school_shift_id', $request->school_shift_id)
            ->where('id', '!=', $id)
            ->exists();
        if ($duplicateShiftExists) {
            toastr()->error('Không thể cập nhật vì ca học bị trùng trong ngày này.');
            return back()
                ->withErrors(['school_shift_id' => 'Lớp đã có ca này trong ngày đã chọn. Vui lòng chọn ca khác.'])
                ->withInput();
        }

        // Bảo đảm có class_subject phù hợp
        $classSubject = ClassSubject::firstOrCreate(
            [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ],
            [
                'student_count' => 0,
                'start_date' => $scheduleDate,
                'end_date' => $scheduleDate,
            ]
        );

        $schedule = Schedules::findOrFail($id);
        $schedule->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'class_subject_id' => $classSubject->id,
            'school_shift_id' => $request->school_shift_id,
            'room_id' => $request->room_id,
            'schedule_date' => $scheduleDate,
            'day_of_week' => $request->day_of_week,
            'updated_by' => session('user_id'),
        ]);

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật lịch dạy thành công',
                'schedule' => $schedule
            ]);
        }
        
        toastr()->success('Cập nhật lịch dạy thành công');
        return redirect()->route('teaching_schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->delete();

        toastr()->success('Xóa lịch dạy thành công');
        return redirect()->route('teaching_schedule.index');
    }

    /**
     * Export teaching schedules to Excel
     */
    public function export(Request $request)
    {
        $keyword = $request->get('keyword');
        return Excel::download(new TeachingSchedulesExport($keyword), 'danh_sach_lich_day_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
