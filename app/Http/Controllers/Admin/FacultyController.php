<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        }

        $data = $query->paginate(10);
        $template = "admin.faculty.faculty.pages.index";

        return view('admin.dashboard.layout', compact(
            'template',
            'data'
        ));
    }

    public function create()
    {
        $template = "admin.faculty.faculty.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/faculty.css'
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
            'config'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:faculties,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Faculty::create($validatedData);

        toastr()->success('Tạo khoa thành công');
        return redirect()->route('faculty.index');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        $template = "admin.faculty.faculty.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/faculty.css'
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
            'faculty'
        ));
    }

    public function update(Request $request, $id)
    {
        $faculty = Faculty::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:faculties,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $faculty->update($validatedData);

        toastr()->success('Cập nhật khoa thành công');
        return redirect()->route('faculty.index');
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        toastr()->success('Xóa khoa thành công');
        return redirect()->route('faculty.index');
    }
}
