<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    // Hiển thị danh sách ngành học
    public function index(Request $request)
    {
        $query = Major::query();

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('code', 'LIKE', "%$search%");
            });
        }

        if ($request->has('course_id') && $request->input('course_id') != '') {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }


        $courses = Courses::all();

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

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        $template = "admin.major.major.pages.index";

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'courses'
        ));
    }



    // Hiển thị form tạo ngành học mới
    public function create()
    {
        $courses = Courses::all();
        $template = "admin.major.major.pages.store";

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

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'courses'
        ));
    }

    // Lưu ngành học mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:majors,code',
            'name' => 'required|string|max:255',
            'standard' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:0,1',
        ], [
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.unique' => 'Mã môn học đã tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'standard.required' => 'Tiêu chuẩn là bắt buộc.',
            'course_id.required' => 'Khóa học là bắt buộc.',
            'course_id.exists' => 'Khóa học không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        Major::create($validatedData);

        toastr()->success('Thêm bản ghi thành công!');
        return redirect()->route('major.index');
    }

    // Hiển thị form chỉnh sửa ngành học
    public function edit($id)
    {
        $major = Major::findOrFail($id);
        $courses = Courses::all();
        $template = "admin.major.major.pages.store";

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
                '/admin.lib/library.js',
            ]
        ];

        $config['method'] = 'edit';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'major',
            'courses'
        ));
    }

    // Cập nhật ngành học trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:majors,code,' . $id,
            'name' => 'required|string|max:255',
            'standard' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:0,1',
        ], [
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.unique' => 'Mã môn học đã tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'standard.required' => 'Tiêu chuẩn là bắt buộc.',
            'course_id.required' => 'Khóa học là bắt buộc.',
            'course_id.exists' => 'Khóa học không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $major = Major::findOrFail($id);
        $major->update($validatedData);

        toastr()->success('Chỉnh sửa bản ghi thành công!');
        return redirect()->route('major.index');
    }

    // Xóa ngành học khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        toastr()->success('Xóa bản ghi thành công!');
        return redirect()->route('major.index');
    }
}

