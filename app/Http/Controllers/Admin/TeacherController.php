<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Models\Courses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Major;
use App\Models\Account;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Support\Facades\Storage;
class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Teachers::query();
    
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
        }
    
        // Eager load course and major relationships
        $data = $query->with(['course', 'major'])->orderBy('id', 'asc')->paginate(10);
    
        $template = "admin.teacher.teacher.pages.index";
    
        return view('admin.dashboard.layout', compact('template', 'data', 'search'));
    }
    
    

    public function create()
    {
        $data = Courses::orderBy('name', 'asc')->get();

        $courses = Courses::orderBy('name', 'asc')->get();
        $majors = Major::all();

        $template = "admin.teacher.teacher.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/teacher.css'
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

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'courses',
            'majors'
        ));
    }

    public function store(StoreTeacherRequest $request)
{
    $data = new Teachers();
    $data->name = $request->input('teacher_name');
    $data->code = $this->generateTeacherCode($request->input('teacher_name'));
    $data->email = $request->input('teacher_email');
    $data->phone = $request->input('teacher_phone');
    $data->address = $request->input('teacher_address');
    $data->qualifications = $request->input('teacher_qualifications');
    $data->current_address = $request->input('teacher_current_address');
    $data->gender = $request->input('teacher_gender');
    $data->date_of_birth = $request->input('teacher_date_of_birth');
    $data->bio = $request->input('teacher_bio');
    $data->course_id = $request->input('course_id');
    $data->major_id = $request->input('major_id');
    $data->role_id = 3;
    $data->OTP = 332456;

    // --- ẢNH ĐẠI DIỆN ---
    if ($request->hasFile('teacher_image')) {
        $file = $request->file('teacher_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/teacher'), $filename);
        $data->image = $filename;
    }

    // --- CCCD MẶT TRƯỚC ---
    if ($request->hasFile('teacher_cccd_front')) {
        $file = $request->file('teacher_cccd_front');
        $filename = time() . '_cccd_front.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/teacher'), $filename);
        $data->cccd_front = $filename;
    }

    // --- CCCD MẶT SAU ---
    if ($request->hasFile('teacher_cccd_back')) {
        $file = $request->file('teacher_cccd_back');
        $filename = time() . '_cccd_back.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/teacher'), $filename);
        $data->cccd_back = $filename;
    }

    $data->save();

    return redirect()->route('teacher.index')->with('status', 'Thêm giáo viên thành công');
}


    private function generateTeacherCode($name)
{
    // Loại bỏ dấu tiếng Việt
    $name = $this->removeVietnameseTones($name);
    // Chuyển hết về chữ thường
    $name = strtolower($name);
    // Tạo mã code từ chữ cái đầu của mỗi từ
    $words = explode(' ', $name);
    $code = '';
    foreach ($words as $w) {
        $code .= substr($w, 0, 2);
    }
    // Xóa ký tự đặc biệt
    $code = preg_replace('/[^a-z0-9]/', '', $code);
    return substr($code, 0, 255);
}

private function removeVietnameseTones($str)
{
    $unicode = [
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd'=>'đ','D'=>'Đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i'=>'í|ì|ỉ|ĩ|ị','I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ','Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
    ];
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/u", $nonUnicode, $str);
    }
    return $str;
}


    public function edit($id)
    {
        $teacher = Teachers::find($id);

        $data = Courses::orderBy('name', 'asc')->get();
        $courses = Courses::orderBy('name', 'asc')->get();
        $majors = Major::all();

        $template = "admin.teacher.teacher.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/teacher.css'
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
            'data',
            'teacher',
            'courses',
            'majors'
        ));
    }

    public function update(UpdateTeacherRequest $request, $id)
{
    $teacher = Teachers::find($id);
    if (!$teacher) {
        return redirect()->route('teacher.index')->withErrors(['message' => 'Giáo viên không tồn tại.']);
    }

    // Kiểm tra email trùng lặp (nếu đổi email)
    $newEmail = $request->input('teacher_email');
    if ($newEmail && $newEmail !== $teacher->email) {
        $exists = Teachers::where('email', $newEmail)
            ->where('id', '<>', $id)
            ->exists();
        if ($exists) {
            return redirect()->back()
                ->withErrors(['teacher_email' => 'Email này đã được sử dụng.'])
                ->withInput();
        }
        $teacher->email = $newEmail;
    }

    // Cập nhật các trường cơ bản
    $teacher->name = $request->input('teacher_name');
    $teacher->phone = $request->input('teacher_phone');
    $teacher->address = $request->input('teacher_address');
    $teacher->current_address = $request->input('teacher_current_address');
    $teacher->gender = $request->input('teacher_gender');
    $teacher->date_of_birth = $request->input('teacher_date_of_birth');
    $teacher->bio = $request->input('teacher_bio');
    $teacher->course_id = $request->input('course_id');
    $teacher->major_id = $request->input('major_id');
    $teacher->role_id = 3;
    $teacher->OTP = 332456;
    $teacher->qualifications = $request->input('teacher_qualifications');

    // --- Ảnh đại diện ---
    if ($request->hasFile('teacher_image')) {
        $oldPath = 'uploads/teacher/' . $teacher->image;
        if (File::exists($oldPath)) File::delete($oldPath);

        $file = $request->file('teacher_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/teacher/', $filename);
        $teacher->image = $filename;
    }

    // --- CCCD Mặt trước ---
    if ($request->hasFile('teacher_cccd_front')) {
        $oldFront = 'uploads/teacher/' . $teacher->cccd_front;
        if (File::exists($oldFront)) File::delete($oldFront);

        $file = $request->file('teacher_cccd_front');
        $filename = time() . '_cccd_front.' . $file->getClientOriginalExtension();
        $file->move('uploads/teacher/', $filename);
        $teacher->cccd_front = $filename;
    }

    // --- CCCD Mặt sau ---
    if ($request->hasFile('teacher_cccd_back')) {
        $oldBack = 'uploads/teacher/' . $teacher->cccd_back;
        if (File::exists($oldBack)) File::delete($oldBack);

        $file = $request->file('teacher_cccd_back');
        $filename = time() . '_cccd_back.' . $file->getClientOriginalExtension();
        $file->move('uploads/teacher/', $filename);
        $teacher->cccd_back = $filename;
    }

    // Lưu thay đổi
    $teacher->save();

    // ✅ Sau khi cập nhật xong -> quay về trang danh sách
    return redirect()->route('teacher.index')->with('status', 'Cập nhật giáo viên thành công!');
}


    



    public function delete($id)
    {
        $data = Teachers::find($id);
    }

    public function destroy($id)
    {
        $teacher = Teachers::find($id);
        $imagePath = 'uploads/teacher/' . $teacher->image;
        $cccdPath = 'uploads/teacher/' . $teacher->cccd;

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        if (File::exists($cccdPath)) {
            File::delete($cccdPath);
        }

        $teacher->delete();

        return redirect()->route('teacher.index')->with('status', 'Xóa giáo viên thành công');
    }
      public function getMajorsByCourse(Request $request)
    {
        $courseId = $request->input('course_id');
        $majors = Major::where('course_id', $courseId)->get();

        return response()->json($majors);
    }
}
