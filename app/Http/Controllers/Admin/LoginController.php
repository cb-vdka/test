<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmOtpRequest;
use App\Http\Requests\SendOtpRequest;
use App\Mail\SendOtpLogin;
use App\Models\Account;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\TrainingOfficer\TrainingOfficerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        // Giao diện đăng nhập - không cần chọn role trước
        return view('admin.auth.login');
    }

    // new
    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();
        
        // Debug: Log login attempt
        Log::info('Login attempt', [
            'email' => $data['email'],
            'session_id' => session()->getId()
        ]);
        
        // Tìm kiếm trong tất cả các bảng để xác định role
        $user = null;
        $userRole = null;
        
        // 1. Tìm trong bảng accounts (Admin, Super Admin)
        $user = Account::where('email', $data['email'])->first();
        if ($user) {
            $userRole = $user->role_id;
            Log::info('User found in accounts table', [
                'user_id' => $user->id,
                'role_id' => $userRole
            ]);
        }
        
        // 2. Nếu không tìm thấy, tìm trong bảng students
        if (!$user) {
            $user = Students::where('email', $data['email'])->first();
            if ($user) {
                $userRole = 2; // Student role
                Log::info('User found in students table', [
                    'user_id' => $user->id,
                    'role_id' => $userRole
                ]);
            }
        }
        
        // 3. Nếu không tìm thấy, tìm trong bảng teachers
        if (!$user) {
            $user = Teachers::where('email', $data['email'])->first();
            if ($user) {
                $userRole = 3; // Teacher role
                Log::info('User found in teachers table', [
                    'user_id' => $user->id,
                    'role_id' => $userRole
                ]);
            }
        }
        
        // 4. Nếu không tìm thấy, tìm trong bảng training_officer_accounts
        if (!$user) {
            $user = TrainingOfficerAccount::where('email', $data['email'])->first();
            if ($user) {
                $userRole = 4; // Training Officer role
            Log::info('User found in training_officer_accounts table', [
                    'user_id' => $user->id,
                    'role_id' => $userRole
                ]);
            }
        }

        // Kiểm tra user có tồn tại không
        if (!$user) {
            Log::info('User not found for email: ' . $data['email']);
            toastr()->error('Email hoặc mật khẩu không chính xác');
            return back();
        }

        // Kiểm tra xem user có password không
        if (empty($user->password)) {
            Log::info('User found but no password set', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole
            ]);
            toastr()->error('Tài khoản chưa được thiết lập mật khẩu');
            return back();
        }

        // Kiểm tra password
        if (!Hash::check($data['password'], $user->password)) {
            Log::info('Password mismatch', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole
            ]);
            toastr()->error('Email hoặc mật khẩu không chính xác');
            return back();
        }

        Log::info('Login successful', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $userRole,
            'table_source' => $user instanceof Account ? 'accounts' : 'other'
        ]);

        // Đảm bảo tài khoản giảng viên có bản ghi trong bảng teachers và session user_id trỏ về teachers.id
        if (in_array($userRole, [3, 16], true)) {
            // Nếu user lấy từ bảng accounts/training_officer..., ánh xạ sang teachers theo email
            $teacherEmail = data_get($user, 'email', $data['email'] ?? null);
            $teacherName = data_get($user, 'name', $data['email'] ?? 'Teacher');
            $teacher = $teacherEmail ? Teachers::where('email', $teacherEmail)->first() : null;
            if (!$teacher) {
                // Tạo nhanh bản ghi teacher nếu chưa có (tối thiểu name, email, phone bắt buộc)
                $teacher = Teachers::create([
                    'name' => $teacherName,
                    'email' => $teacherEmail,
                    'phone' => data_get($user, 'phone', '0000000000'),
                    'OTP' => random_int(111111, 999999),
                ]);
            }

            // Set session theo teacher để các controller sử dụng đúng teachers.id
            $this->setSessionData($request, (object) [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'phone' => $teacher->phone ?? null,
                'course_id' => $teacher->course_id ?? null,
            ], $userRole);
        } else {
            // Set session data với role đã xác định cho các role khác
            $this->setSessionData($request, $user, $userRole);
        }
        
        toastr()->success('Đăng Nhập Thành Công');
        
        // Redirect theo role
        if (in_array($userRole, [3, 16], true)) {
            // Teacher - redirect to teacher dashboard
            return redirect()->route('teacher.teaching_schedule.index');
        } elseif ($userRole == 2) {
            // Student - redirect to student dashboard
            return redirect()->route('schedule.index');
        } else {
            // Admin/Super Admin - redirect to admin dashboard
            return redirect()->route('dashboard.index');
        }
    }

    private function setSessionData(Request $request, $user, $userRole = null)
    {
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_email', $user->email);
        $request->session()->put('user_role', $userRole ?? $user->role_id);

        // if (property_exists($user, 'name')) {
        //     $request->session()->put('user_name', $user->name);
        // }

         $request->session()->put('user_name', $user->name);

        if (property_exists($user, 'phone')) {
            $request->session()->put('user_phone', $user->phone);
        }

        if (property_exists($user, 'major_id')) {
            $request->session()->put('user_major_id', $user->major_id);
        }

        if (property_exists($user, 'year_of_enrollment')) {
            $request->session()->put('user_year_of_enrollment', $user->year_of_enrollment);
        }

        if (property_exists($user, 'course_id')) {
            $request->session()->put('user_course_id', $user->course_id);
        }
    }
    //end  new



    // public function send_otp(SendOtpRequest $request)
    // {
    //     $data = $request->validated();

    //     if (!empty(session('user_role_login') == 1)) {
    //         Account::where('email', '=', $data['email'])
    //             ->update(['OTP' => rand(111111, 999999)]);

    //         $getOtp = Account::select('OTP');
    //     } else if (!empty(session('user_role_login') == 2)) {
    //         Students::where('email', '=', $data['email'])
    //             ->update(['OTP' => rand(111111, 999999)]);

    //         $getOtp = Students::select('OTP');
    //     } else if (!empty(session('user_role_login') == 3)) {
    //         Teachers::where('email', '=', $data['email'])
    //             ->update(['OTP' => rand(111111, 999999)]);

    //         $getOtp = Teachers::select('OTP');
    //     } else {
    //         TrainingOfficerAccount::where('email', '=', $data['email'])
    //             ->update(['OTP' => rand(111111, 999999)]);

    //         $getOtp = TrainingOfficerAccount::select('OTP');
    //     }

    //     $getOtp = $getOtp
    //         ->where('email', $data['email'])
    //         ->where('role_id', session('user_role_login'))
    //         ->first();

    //     if ($getOtp) {
    //         $subject = 'Yêu Cầu Gửi Mã OTP Xác Thực';

    //         Mail::to($data['email'])->send(new SendOtpLogin($getOtp->OTP, $subject));

    //         $request->session()->put('session_otp', $getOtp->OTP);

    //         toastr()->success('Mã OTP Đã Gửi Về Email Của Bạn, Vui Lòng Kiểm Tra');
    //         return redirect()->route('login.enter_otp');
    //     } else {
    //         toastr()->error('Email không tồn tại trên hệ thống');
    //         return back();
    //     }
    // }

    // public function enter_otp(Request $request)
    // {
    //     // Giao diện trang nhập mã OTP
    //     return view('admin.auth.enter_otp');
    // }

    // public function confirm_otp(ConfirmOtpRequest $request)
    // {
    //     // Xác nhận mã OTP tại đây và lưu session('user_id'), session('user_name'), session('user_email'), session('user_role') sau đó redirect()->route('dashboard.index');
    //     $data = $request->validated();

    //     if ($data) {
    //         if (!empty(session('user_role_login') == 1)) {
    //             $confirmAccount = Account::where('OTP', session('session_otp'))->first();

    //             if ($confirmAccount) {
    //                 $request->session()->put('user_id', $confirmAccount->id);
    //                 $request->session()->put('user_name', $confirmAccount->name);
    //                 $request->session()->put('user_email', $confirmAccount->email);
    //                 $request->session()->put('user_role', $confirmAccount->role_id);
    //             } else {
    //                 toastr()->error('Mã OTP Không Chính Xác');
    //                 return back();
    //             }
    //         } else if (!empty(session('user_role_login') == 2)) {
    //             $confirmStudent = Students::where('OTP', session('session_otp'))->first();

    //             if ($confirmStudent) {
    //                 $request->session()->put('user_id', $confirmStudent->id);
    //                 $request->session()->put('user_name', $confirmStudent->name);
    //                 $request->session()->put('user_email', $confirmStudent->email);
    //                 $request->session()->put('user_phone', $confirmStudent->phone);
    //                 $request->session()->put('user_major_id', $confirmStudent->major_id);
    //                 $request->session()->put('user_year_of_enrollment', $confirmStudent->year_of_enrollment);
    //                 $request->session()->put('user_role', $confirmStudent->role_id);
    //             } else {
    //                 toastr()->error('Mã OTP Không Chính Xác');
    //                 return back();
    //             }
    //         } else if (!empty(session('user_role_login') == 3)) {
    //             $confirmTeacher = Teachers::where('OTP', session('session_otp'))->first();

    //             if ($confirmTeacher) {
    //                 $request->session()->put('user_id', $confirmTeacher->id);
    //                 $request->session()->put('user_name', $confirmTeacher->name);
    //                 $request->session()->put('user_email', $confirmTeacher->email);
    //                 $request->session()->put('user_phone', $confirmTeacher->phone);
    //                 $request->session()->put('user_course_id', $confirmTeacher->course_id);
    //                 $request->session()->put('user_role', $confirmTeacher->role_id);
    //             } else {
    //                 toastr()->error('Mã OTP Không Chính Xác');
    //                 return back();
    //             }
    //         } else {
    //             $confirmTrainingOfficer = TrainingOfficerAccount::where('OTP', session('session_otp'))->first();

    //             if ($confirmTrainingOfficer) {
    //                 $request->session()->put('user_id', $confirmTrainingOfficer->id);
    //                 $request->session()->put('user_email', $confirmTrainingOfficer->email);
    //                 $request->session()->put('user_role', $confirmTrainingOfficer->role_id);
    //             } else {
    //                 toastr()->error('Mã OTP Không Chính Xác');
    //                 return back();
    //             }
    //         }

    //         toastr()->success('Đăng Nhập Thành Công');
    //         return redirect()->route('dashboard.index');
    //     }
    // }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        // !empty(session('user_role_login') == 1)

        if (!empty(session('user_role_login') == 1)) {
            $getAccountGoogle = Account::select('*');
        } else if (!empty(session('user_role_login') == 2)) {
            $getAccountGoogle = Students::select('*');
        } else if (!empty(session('user_role_login') == 3)) {
            $getAccountGoogle = Teachers::select('*');
        } else {
            $getAccountGoogle = TrainingOfficerAccount::select('*');
        }

        $getAccountGoogle = $getAccountGoogle
            ->where('email', $user->email)
            ->where('role_id', session('user_role_login'))
            ->first();

        if ($getAccountGoogle) {

            if ($getAccountGoogle->role_id == 1) {
                $request->session()->put('user_id', $getAccountGoogle->id);
                $request->session()->put('user_name', $getAccountGoogle->name);
                $request->session()->put('user_email', $getAccountGoogle->email);
                $request->session()->put('user_role', $getAccountGoogle->role_id);
            } else if ($getAccountGoogle->role_id == 2) {
                $request->session()->put('user_id', $getAccountGoogle->id);
                $request->session()->put('user_name', $getAccountGoogle->name);
                $request->session()->put('user_email', $getAccountGoogle->email);
                $request->session()->put('user_phone', $getAccountGoogle->phone);
                $request->session()->put('user_major_id', $getAccountGoogle->major_id);
                $request->session()->put('user_year_of_enrollment', $getAccountGoogle->year_of_enrollment);
                $request->session()->put('user_role', $getAccountGoogle->role_id);
            } elseif ($getAccountGoogle->role_id == 3) {
                $request->session()->put('user_id', $getAccountGoogle->id);
                $request->session()->put('user_name', $getAccountGoogle->name);
                $request->session()->put('user_email', $getAccountGoogle->email);
                $request->session()->put('user_phone', $getAccountGoogle->phone);
                $request->session()->put('user_course_id', $getAccountGoogle->course_id);
                $request->session()->put('user_role', $getAccountGoogle->role_id);
            } else {
                $request->session()->put('user_id', $getAccountGoogle->id);
                $request->session()->put('user_email', $getAccountGoogle->email);
                $request->session()->put('user_role', $getAccountGoogle->role_id);
            }

            // Redirect theo role
            if (in_array($getAccountGoogle->role_id, [3, 16], true)) {
                // Teacher - redirect to teacher dashboard
                return redirect()->route('teacher.teaching_schedule.index');
            } elseif ($getAccountGoogle->role_id == 2) {
                // Student - redirect to student dashboard
                return redirect()->route('schedule.index');
            } else {
                // Admin/Super Admin - redirect to admin dashboard
                return redirect()->route('dashboard.index');
            }
        }

        toastr()->error('Tài khoản không tồn tại trên hệ thống');

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_name', 'user_email', 'user_phone', 'user_major_id', 'user_year_of_enrollment', 'user_role', 'user_course_id', 'user_chat_id', 'user_chat_name', 'user_id']);
        return redirect()->route('home');
    }
}