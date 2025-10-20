<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedules;
use App\Models\Teachers;
use Illuminate\Http\Request;

class TeachingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Kiểm tra role teacher (chấp nhận role 3 và 16)
        if (!in_array(session('user_role'), [3, 16], true)) {
            return redirect()->route('dashboard.index')->with('error', 'Bạn không có quyền truy cập trang lịch dạy.');
        }
        
        $template = "teacher.teaching_schedule.pages.index";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/teacher/css/teaching_schedule.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];

        // Lấy thông tin giáo viên hiện tại - ưu tiên theo session user_id
        $teacher = null;
        $teacherIds = [];
        
        // Thử tìm teacher theo session user_id trước
        if (session('user_id')) {
            $teacher = Teachers::find(session('user_id'));
            if ($teacher) {
                $teacherIds[] = $teacher->id;
            }
        }
        
        // Nếu không tìm thấy theo ID, thử theo email/name
        if (!$teacher && session('user_email')) {
            $teacher = Teachers::where('email', session('user_email'))->first();
            if ($teacher) {
                $teacherIds[] = $teacher->id;
            }
        }
        
        // Nếu vẫn không tìm thấy, thử theo name
        if (!$teacher && session('user_name')) {
            $teacher = Teachers::where('name', session('user_name'))->first();
            if ($teacher) {
                $teacherIds[] = $teacher->id;
            }
        }
        
        // Loại bỏ duplicate và đảm bảo có giá trị
        $teacherIds = array_values(array_unique(array_filter($teacherIds)));

        // Debug nhanh: thêm ?debug=1 để xem xét sự trùng khớp dữ liệu
        if ($request->boolean('debug')) {
            return response()->json([
                'session' => [
                    'user_id' => session('user_id'),
                    'user_email' => session('user_email'),
                    'user_name' => session('user_name'),
                    'user_role' => session('user_role'),
                ],
                'found_teacher' => $teacher,
                'teacher_ids' => $teacherIds,
                'schedules_count' => empty($teacherIds) ? 0 : Schedules::whereIn('teacher_id', $teacherIds)->count(),
                'all_teachers_sample' => Teachers::take(5)->get(['id', 'name', 'email'])->toArray(),
                'all_schedules_sample' => Schedules::with('teacher')->take(5)->get(['id', 'teacher_id', 'schedule_date', 'class_id'])->toArray()
            ]);
        }

        if (empty($teacherIds)) {
            return redirect()->route('dashboard.index')->with('error', 'Không tìm thấy thông tin giáo viên.');
        }

        // Lấy từ khóa tìm kiếm
        $search = $request->input('keyword');

        // Truy vấn lịch dạy của giáo viên hiện tại
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
            ->leftJoin('classrooms', 'schedules.room_id', '=', 'classrooms.id')
            ->whereIn('class_subjects.teacher_id', $teacherIds); // Cho phép nhiều ID giáo viên tương thích

        // Nếu có từ khóa tìm kiếm
        if (!empty($search)) {
            $getAllTeachingSchedule->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(classes.name) LIKE ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(subjects.name) LIKE ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(teachers.name) LIKE ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(school_shifts.name) LIKE ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(classrooms.name) LIKE ?", ["%" . strtolower($search) . "%"]);
            });
        }

        // Lấy tất cả dữ liệu cho lịch (không phân trang)
        $getAllTeachingSchedule = $getAllTeachingSchedule
            ->orderBy('schedules.schedule_date', 'ASC')
            ->orderBy('school_shifts.start_time', 'ASC')
            ->get();

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'schedules' => $getAllTeachingSchedule->toArray()
            ]);
        }

        // Log debug info
        \Log::info('Teacher schedule debug:', [
            'teacher_ids' => $teacherIds,
            'schedules_found' => $getAllTeachingSchedule->count(),
            'teacher_session_id' => session('user_id'),
            'teacher_email' => session('user_email')
        ]);

        $breadcrumb = [
            ['title' => 'Lịch huấn luyện', 'url' => null]
        ];

        return view('teacher.dashboard.layout', compact(
            'template',
            'getAllTeachingSchedule',
            'config',
            'teacher',
            'breadcrumb'
        ));
    }

    /**
     * Debug route to check teacher and schedules
     */
    public function debug(Request $request)
    {
        $teacher = Teachers::find(session('user_id'));
        $teacherByEmail = Teachers::where('email', session('user_email'))->first();
        
        $allSchedules = Schedules::with(['teacher', 'class', 'subject'])->get();
        $teacherSchedules = [];
        
        if ($teacher) {
            $teacherSchedules = Schedules::where('teacher_id', $teacher->id)->get();
        }
        
        return response()->json([
            'session_data' => [
                'user_id' => session('user_id'),
                'user_email' => session('user_email'),
                'user_name' => session('user_name'),
                'user_role' => session('user_role'),
            ],
            'teacher_by_id' => $teacher,
            'teacher_by_email' => $teacherByEmail,
            'teacher_schedules_count' => $teacherSchedules->count(),
            'teacher_schedules' => $teacherSchedules,
            'all_schedules_sample' => $allSchedules->take(3),
            'all_teachers_sample' => Teachers::take(3)->get(['id', 'name', 'email'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Giáo viên không được phép tạo lịch mới
        return redirect()->back()->with('error', 'Bạn không có quyền tạo lịch dạy mới.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy giáo viên ưu tiên theo session user_id; fallback email/name nếu cần
        $teacher = null;
        if (in_array(session('user_role'), [3, 16], true)) {
            $teacher = Teachers::find(session('user_id'));
        }
        if (!$teacher) {
            $teacher = Teachers::where('email', session('user_email'))
                ->orWhere('name', session('user_name'))
                ->first();
        }
        $teacherId = $teacher?->id;
        
        $schedule = Schedules::select(
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
            ->leftJoin('classrooms', 'schedules.room_id', '=', 'classrooms.id')
            ->where('schedules.id', $id)
            ->where('class_subjects.teacher_id', $teacherId) // Chỉ xem lịch của mình
            ->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'Không tìm thấy lịch dạy hoặc bạn không có quyền xem lịch này.');
        }

        $template = "teacher.teaching_schedule.pages.show";
        $config = [
            'css' => [
                '/teacher/css/teaching_schedule.css'
            ]
        ];

        $breadcrumb = [
            ['title' => 'Lịch huấn luyện', 'url' => route('teacher.teaching_schedule.index')],
            ['title' => 'Chi tiết lịch huấn luyện', 'url' => null]
        ];

        return view('teacher.dashboard.layout', compact(
            'template',
            'schedule',
            'config',
            'breadcrumb'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Giáo viên không được phép chỉnh sửa lịch
        return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa lịch dạy.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Giáo viên không được phép chỉnh sửa lịch
        return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa lịch dạy.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Giáo viên không được phép xóa lịch
        return redirect()->back()->with('error', 'Bạn không có quyền xóa lịch dạy.');
    }
}