<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use \App\Models\Students;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;
use App\Models\Courses;
use App\Models\StudyStatus;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $province;
    public function __construct()
    {
        $this->province = new Students();
    }
    public function index(Request $request)
    {
        $sort = 10;

        $major_id = null;

        if (!empty($request->sort)) {
            $sort = $request->sort;
        }

        if (!empty($request->major_id)) {
            $major_id = $request->major_id;
        }

        $getAllStudent = $this->province->getAllStudent($request->keyword, $sort, $major_id);

        $getMajor = Major::all();

        $template = "admin.student.student.pages.index";

        return view('admin.dashboard.layout', compact('template', 'getAllStudent', 'getMajor'));
    }
    public function create()
    {
        $getMajor = Major::all();

        $getCoures = Courses::all();

        $getStudyStatus = StudyStatus::all();

        $template = "admin.student.student.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
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

        // Clear old input data khi vào trang tạo mới
        session()->forget('_old_input');

        return view(
            'admin.dashboard.layout',
            compact(
                'template',
                'config',
                'getMajor',
                'getCoures',
                'getStudyStatus',
            )
        );
    }
    public function store(StoreStudentRequest $request)
    {
        // Debug: Log tất cả dữ liệu request
        \Log::info('Student creation request data:', $request->all());
        
        $data = $request->validated();
        if ($data) {
            // Kiểm tra email đã tồn tại chưa
            $existingAccount = Account::where('email', $request->email)->first();
            if ($existingAccount) {
                toastr()->error('Email đã được sử dụng cho tài khoản khác. Vui lòng sử dụng email khác.');
                return back();
            }

            // Tạo mã học viên tự động: AA + số tự tăng
            $autoStudentCode = Students::generateStudentCode();
            
            // Tạo password tự động: sử dụng số điện thoại
            $autoPassword = Students::generatePassword($request->phone);
            $hashedPassword = Hash::make($autoPassword);

            // Tạo account trong bảng accounts
            $account = new Account();
            $account->name = $request->name;
            $account->email = $request->email;
            $account->password = $hashedPassword;
            $account->role_id = 2; // Student role
            $account->OTP = rand(111111, 999999);
            $account->created_by = session('user_id');
            $account->save();

            // Tạo học viên trong bảng students
            $student = new Students();
            $student->name = $request->name;
            $student->student_code = $autoStudentCode; // Sử dụng mã tự động
            $student->gender = (int)$request->gender; // Convert to integer
            $student->date_of_birth = $request->date_of_birth;
            $student->email = $request->email;
            $student->password = $hashedPassword; // Lưu password đã hash
            $student->address = $request->address;
            $student->course_id = $request->course_id;
            $student->major_id = $request->major_id;
            $student->cccd_number = $request->cccd_number;
            $student->cccd_issue_date = $request->cccd_issue_date;
            $student->cccd_place = $request->cccd_place;
            $student->year_of_enrollment = $request->year_of_enrollment;
            $student->study_status_id = $request->study_status_id ?? 1; // Fallback to 1 if null
            $student->semesters = $request->semesters ?? 1; // Fallback to 1 if null
            
            // Debug: Log giá trị semesters và study_status_id
            \Log::info('Semesters value: ' . ($request->semesters ?? 'NULL'));
            \Log::info('Study status ID value: ' . ($request->study_status_id ?? 'NULL'));
            $student->phone = $request->phone;
            $student->role_id = 2;
            $student->OTP = rand(111111, 999999);
            $student->created_by = session('user_id');

            $student->save();

            // Lưu thông tin đăng nhập vào session để hiển thị
            session([
                'new_student_login_info' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $autoPassword, // Số điện thoại
                    'student_code' => $autoStudentCode // Mã học viên tự động
                ]
            ]);

            toastr()->success('Thêm học viên thành công! Mã học viên và thông tin đăng nhập đã được tạo tự động.');

            // Clear form data sau khi thêm thành công
            $request->session()->forget('_old_input');
            
            return redirect()->route('student.index');
        }
        toastr()->error('Có lỗi xảy ra, vui lòng thử lại!');
        return back();
    }

    public function edit(Request $request)
    {
        $getMajor = Major::all();

        $getCoures = Courses::all();

        $getStudyStatus = StudyStatus::all();

        $request->session()->put('student_id_session', $request->id);

        $getEdit = $this->province->getEditStudent(session('student_id_session'));

        $template = "admin.student.student.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
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

        return view(
            'admin.dashboard.layout',
            compact(
                'template',
                'config',
                'getEdit',
                'getMajor',
                'getCoures',
                'getStudyStatus',
            )
        );
    }

   public function update(UpdateStudentRequest $request)
{
    $data = $request->validated();

    // Tìm học viên theo session
    $student = Students::find(session('student_id_session'));
    if (!$student) {
        toastr()->error('Không tìm thấy học viên!');
        return redirect()->route('student.index');
    }

    // Kiểm tra email trùng (trừ email cũ của học viên)
    $checkEmail = Students::where('email', $request->email)
        ->where('id', '!=', $student->id)
        ->first();

    if ($checkEmail) {
        toastr()->error('Email đã tồn tại, vui lòng chọn email khác!');
        return back()->withInput();
    }

    // Gán dữ liệu
    $student->name = $request->name;
    // Nếu muốn giữ mã học viên cố định thì bỏ dòng dưới đi
    $student->student_code = $request->student_code ?? $student->student_code;
    $student->gender = (int)$request->gender;
    $student->date_of_birth = $request->date_of_birth; // Request đã validate nên định dạng chuẩn
    $student->email = $request->email;
    $student->address = $request->address;
    $student->course_id = $request->course_id;
    $student->major_id = $request->major_id;
    $student->cccd_number = $request->cccd_number;
    $student->cccd_issue_date = $request->cccd_issue_date;
    $student->cccd_place = $request->cccd_place;
    $student->year_of_enrollment = $request->year_of_enrollment;
    $student->study_status_id = $request->study_status_id;
    $student->semesters = $request->semesters ?? $student->semesters;
    $student->phone = $request->phone;
    $student->updated_by = session('user_id');
    $student->save();

    // Cập nhật thông tin account nếu tồn tại
    $account = Account::where('email', $student->email)->first();
    if ($account) {
        $account->name = $student->name;
        $account->email = $student->email;
        $account->save();
    }

    // Xóa session tạm
    $request->session()->forget('student_id_session');

    toastr()->success('Cập nhật học viên thành công!');
    return redirect()->route('student.index');
}


    public function trash($id)
    {
        $trash = $this->province::find($id);

        $trash->deleted_by = session('user_id');

        $trash->deleted_at = now();

        $trash->save();

        toastr()->success('Đã Ẩn Sinh Viên');

        return redirect()->route('student.index');
    }

    public function restore($id)
    {
        $trash = $this->province::find($id);

        $trash->deleted_by = null;

        $trash->deleted_at = null;

        $trash->save();

        toastr()->success('Đã Khôi Phục Sinh Viên');

        return redirect()->route('student.index');
    }
    public function delete($id)
    {
        $trash = $this->province::find($id);

        $trash->delete();

        toastr()->success('Đã Xóa Sinh Viên');

        return redirect()->route('student.index');
    }

}
