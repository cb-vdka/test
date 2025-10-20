<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EnrollmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSubject;
use App\Models\Enrollments;
use App\Models\Sics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = session('user_id');
        $classId = $request->query('class_id'); // Lấy class_id từ query string

        // Lấy danh sách các lớp mà giáo viên đang quản lý
        $classes = ClassSubject::where('teacher_id', $teacherId)->get();

        // Xây dựng truy vấn Eloquent
        $query = Enrollments::with(['student', 'classSubject'])
            ->orderBy('created_at', 'ASC');

        // Kiểm tra quyền truy cập của giáo viên
        if (session('user_role') == 3 || session('user_role') == 16) {
            // Tìm teacher theo email hoặc tên từ account
            $account = \App\Models\Account::find($teacherId);
            $teacher = null;
            
            if ($account) {
                // Thử tìm theo email trước
                $teacher = \App\Models\Teachers::where('email', $account->email)->first();
                
                // Nếu không tìm thấy, thử tìm theo tên
                if (!$teacher) {
                    $teacher = \App\Models\Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                }
            }
            
            if ($teacher) {
                $query->whereHas('classSubject', function ($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                });
            } else {
                // Nếu không tìm thấy teacher, trả về kết quả rỗng
                $query->where('id', 0);
            }
        }

        // Lọc theo class_id nếu có
        if (!empty($classId)) {
            // Lấy danh sách sinh viên từ bảng enrollments dựa trên class_subject_id
            $studentQuery = Enrollments::with(['student', 'classSubject'])
                ->where('class_subject_id', $classId);
            
            // Thêm tìm kiếm nếu có
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $studentQuery->whereHas('student', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('student_code', 'like', "%{$search}%");
                });
            }
            
            $students = $studentQuery->orderBy('created_at', 'ASC')->paginate(20);
        } else {
            $students = collect();
        }


        $getAllEnrollment = $query->paginate(10);

        $template = 'admin.enrollment.enrollment.pages.index';

        return view('admin.dashboard.layout', compact(
            'template',
            'getAllEnrollment',
            'classes',
            'students'
        ));
    }


    public function edit($id)
    {
        // Debug: Log thông tin
        Log::info('Edit enrollment ID: ' . $id);
        
        $getEdit = Enrollments::with(['student', 'classSubject'])->find($id);
        
        Log::info('Enrollment found: ' . ($getEdit ? 'Yes' : 'No'));
        if ($getEdit) {
            Log::info('Student: ' . $getEdit->student->name . ', ClassSubject: ' . $getEdit->class_subject_id);
        }

        if (!$getEdit) {
            return redirect()->route('enrollment.index')->with('error', 'Enrollment not found.');
        }

        $template = "admin.enrollment.enrollment.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/enrollment.css'
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

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'getEdit'
        ));
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollments::find($id);
        $enrollment->lab_1 = $request->input('lab_1');
        $enrollment->lab_2 = $request->input('lab_2');
        $enrollment->lab_3 = $request->input('lab_3');
        $enrollment->lab_4 = $request->input('lab_4');
        $enrollment->assignment_1 = $request->input('assignment_1');
        $enrollment->assignment_2 = $request->input('assignment_2');
        $enrollment->final_exam = $request->input('final_exam');
        $enrollment->save();

        toastr()->success('Chỉnh sửa bản ghi thành công!');
        return redirect()->back();
    }

    public function classList(Request $request)
    {
        // Lấy ID tài khoản từ session
        $teacherId = session('user_id');
        $userRole = session('user_role');
        
        // Debug: Kiểm tra dữ liệu
        Log::info('Teacher ID from session: ' . $teacherId);
        Log::info('User Role: ' . $userRole);
        
        // Lấy danh sách lớp học
        if ($userRole == 3 || $userRole == 16) { // Teacher role (3 = Giảng viên, 16 = Teacher)
            // Tìm teacher theo email hoặc tên từ account
            $account = \App\Models\Account::find($teacherId);
            $teacher = null;
            
            if ($account) {
                // Thử tìm theo email trước
                $teacher = \App\Models\Teachers::where('email', $account->email)->first();
                
                // Nếu không tìm thấy, thử tìm theo tên
                if (!$teacher) {
                    $teacher = \App\Models\Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                }
            }
            
            if ($teacher) {
                $enrollments = ClassSubject::with(['class', 'subject', 'teacher'])
                    ->where('teacher_id', $teacher->id)
                    ->get();
                Log::info('Found teacher: ' . $teacher->name . ' (ID: ' . $teacher->id . ')');
                Log::info('Enrollments found: ' . $enrollments->count());
            } else {
                $enrollments = collect();
                Log::info('No teacher found for account: ' . ($account ? $account->name : 'Unknown'));
            }
        } else {
            // Admin có thể xem tất cả
            $enrollments = ClassSubject::with(['class', 'subject', 'teacher'])->get();
        }
        
        Log::info('Enrollments found: ' . $enrollments->count());
        
        $template = 'admin.enrollment.enrollment.pages.list';

        return view('admin.dashboard.layout', compact('template', 'enrollments'));
    }

    # Nhập excel
    public function import_excel(Request $request)
    {
        $classId = $request->input('class_id');
        Enrollments::where('class_subject_id', $classId)->delete();

        // ScoreImport đã bị xóa - chức năng import điểm đã bị loại bỏ
        toastr()->error('Chức năng import điểm đã bị loại bỏ!');
        return redirect()->back();
    }

    public function exportExcel($classId)
    {
        // Lấy thông tin lớp dựa trên classId
        $class = Classes::find($classId);
        // Kiểm tra nếu lớp tồn tại
        if ($class) {
            // Lấy tên lớp và tạo tên file
            $className = $class->name;
            $fileName = $className . '.xlsx';
            return FacadesExcel::download(new EnrollmentsExport($classId), $fileName);
        } else {
            // Xử lý trường hợp không tìm thấy lớp
            return redirect()->back()->with('error', 'Lớp không tồn tại.');
        }
    }

    public function setTimeEntryPoint(Request $request)
    {
    }

    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
                'upload_type' => 'required|string|in:ngay_cong,ren_luyen_kha,hoc_gioi,khen_thuong',
                'enrollment_id' => 'required|integer|exists:enrollments,id'
            ]);

            $file = $request->file('excel_file');
            $uploadType = $request->upload_type;
            $enrollmentId = $request->enrollment_id;

            // Lưu file tạm thời
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('temp', $fileName);

            // Xử lý file Excel dựa trên loại upload
            switch ($uploadType) {
                case 'ngay_cong':
                    $this->processNgayCongHocTap($filePath, $enrollmentId);
                    break;
                case 'ren_luyen_kha':
                    $this->processRenLuyenKha($filePath, $enrollmentId);
                    break;
                case 'hoc_gioi':
                    $this->processHocGioi($filePath, $enrollmentId);
                    break;
                case 'khen_thuong':
                    $this->processKhenThuong($filePath, $enrollmentId);
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Upload Excel thành công!'
            ]);

        } catch (\Exception $e) {
            Log::error('Excel upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processNgayCongHocTap($filePath, $enrollmentId)
    {
        // Xử lý file Excel cho Ngày công học tập điều chỉnh
        // TODO: Implement Excel processing logic
        Log::info("Processing ngay_cong for enrollment: $enrollmentId");
    }

    private function processRenLuyenKha($filePath, $enrollmentId)
    {
        // Xử lý file Excel cho Học viên rèn luyện khá
        // TODO: Implement Excel processing logic
        Log::info("Processing ren_luyen_kha for enrollment: $enrollmentId");
    }

    private function processHocGioi($filePath, $enrollmentId)
    {
        // Xử lý file Excel cho Danh sách học viên học giỏi
        // TODO: Implement Excel processing logic
        Log::info("Processing hoc_gioi for enrollment: $enrollmentId");
    }

    private function processKhenThuong($filePath, $enrollmentId)
    {
        // Xử lý file Excel cho Danh sách học viên khen thưởng
        // TODO: Implement Excel processing logic
        Log::info("Processing khen_thuong for enrollment: $enrollmentId");
    }


}