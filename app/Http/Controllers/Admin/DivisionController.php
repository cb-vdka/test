<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $query = Division::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        }

        $data = $query->paginate(10);
        $template = "admin.division.division.pages.index";

        return view('admin.dashboard.layout', compact(
            'template',
            'data'
        ));
    }

    public function create()
    {
        $template = "admin.division.division.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/division.css'
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
            'code' => 'required|string|max:50|unique:divisions,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Division::create($validatedData);

        toastr()->success('Tạo ban thành công');
        return redirect()->route('division.index');
    }

    public function edit($id)
    {
        $division = Division::findOrFail($id);
        $template = "admin.division.division.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/division.css'
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
            'division'
        ));
    }

    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:divisions,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $division->update($validatedData);

        toastr()->success('Cập nhật ban thành công');
        return redirect()->route('division.index');
    }

    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        toastr()->success('Xóa ban thành công');
        return redirect()->route('division.index');
    }
}
