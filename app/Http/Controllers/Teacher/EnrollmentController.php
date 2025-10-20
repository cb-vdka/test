<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassSubject;
use App\Models\Teachers;
use App\Models\Account;
use App\Models\Enrollments;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(session('user_role'), [3, 16], true)) {
            return redirect()->route('dashboard.index');
        }

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

        $classSubjectIds = [];
        if (!empty($teacherIds)) {
            $classSubjectIds = ClassSubject::whereIn('teacher_id', $teacherIds)
                ->pluck('id')
                ->toArray();
        }

        // Nếu có class_id, hiển thị bảng điểm sinh viên
        if ($request->has('class_id')) {
            $classId = $request->get('class_id');
            
            // Lấy thông tin lớp học
            $classEnrollment = Enrollments::with(['classSubject.class', 'classSubject.subject', 'classSubject.teacher'])
                ->where('id', $classId)
                ->whereIn('class_subject_id', $classSubjectIds ?: [0])
                ->first();
            
            if (!$classEnrollment) {
                return redirect()->route('teacher.enrollment.class.list')->with('error', 'Không tìm thấy lớp học');
            }
            
            // Lấy danh sách sinh viên trong lớp
            $students = Enrollments::with(['student', 'classSubject.class', 'classSubject.subject', 'classSubject.teacher'])
                ->where('class_subject_id', $classEnrollment->class_subject_id)
                ->when($request->get('search'), function($query, $search) {
                    return $query->whereHas('student', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('student_code', 'like', '%' . $search . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            
            $template = 'teacher.enrollment.enrollment.pages.index';
            $showScoreTable = true;
            
            return view('teacher.dashboard.layout', compact('template', 'students', 'showScoreTable', 'classEnrollment'));
        }

        // Nếu không có class_id, hiển thị danh sách lớp học
        $baseQuery = Enrollments::query()->whereIn('enrollments.class_subject_id', $classSubjectIds ?: [0]);

        $minIdsPerClass = (clone $baseQuery)
            ->selectRaw('MIN(id) as id')
            ->groupBy('class_subject_id')
            ->pluck('id');

        $studentCounts = (clone $baseQuery)
            ->selectRaw('class_subject_id, COUNT(*) as student_count')
            ->groupBy('class_subject_id')
            ->pluck('student_count', 'class_subject_id');

        $enrollments = Enrollments::with(['classSubject.class', 'classSubject.subject', 'classSubject.teacher'])
            ->whereIn('id', $minIdsPerClass)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $template = 'teacher.enrollment.enrollment.pages.index';

        return view('teacher.dashboard.layout', compact('template', 'enrollments', 'studentCounts'));
    }

    public function classList(Request $request)
    {
        if (!in_array(session('user_role'), [3, 16], true)) {
            return redirect()->route('dashboard.index');
        }

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

        // Lấy danh sách lớp giáo viên đang dạy
        $classSubjectIds = [];
        if (!empty($teacherIds)) {
            $classSubjectIds = ClassSubject::whereIn('teacher_id', $teacherIds)
                ->pluck('id')
                ->toArray();
        }

        // Cơ sở truy vấn enrollments theo các lớp giáo viên dạy
        $baseQuery = Enrollments::query()->whereIn('enrollments.class_subject_id', $classSubjectIds ?: [0]);

        // Lấy id nhỏ nhất mỗi lớp để tránh trùng (đại diện cho 1 lớp)
        $minIdsPerClass = (clone $baseQuery)
            ->selectRaw('MIN(id) as id')
            ->groupBy('class_subject_id')
            ->pluck('id');

        // Đếm số lượng học viên theo lớp
        $studentCounts = (clone $baseQuery)
            ->selectRaw('class_subject_id, COUNT(*) as student_count')
            ->groupBy('class_subject_id')
            ->pluck('student_count', 'class_subject_id');

        // Lấy danh sách lớp (mỗi lớp 1 dòng)
        $enrollments = Enrollments::with(['classSubject.class', 'classSubject.subject', 'classSubject.teacher'])
            ->whereIn('id', $minIdsPerClass)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $template = 'teacher.enrollment.enrollment.pages.list';
        
        // Debug info
        $debugInfo = [
            'teacher_found' => $teacher ? true : false,
            'teacher_id' => $teacher ? $teacher->id : null,
            'teacher_name' => $teacher ? $teacher->name : null,
            'teacher_email' => $teacher ? $teacher->email : null,
            'class_subject_ids' => $classSubjectIds,
            'enrollments_count' => $enrollments->count(),
            'session_user_id' => session('user_id'),
            'session_user_email' => session('user_email'),
            'session_user_name' => session('user_name'),
        ];

        return view('teacher.dashboard.layout', compact('template', 'enrollments', 'studentCounts', 'debugInfo'));
    }
}


