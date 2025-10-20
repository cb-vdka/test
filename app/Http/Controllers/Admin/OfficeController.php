<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $query = Office::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        }

        $data = $query->paginate(10);
        $template = "admin.office.office.pages.index";

        return view('admin.dashboard.layout', compact(
            'template',
            'data'
        ));
    }

    public function create()
    {
        $template = "admin.office.office.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/office.css'
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
            'code' => 'required|string|max:50|unique:offices,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Office::create($validatedData);

        toastr()->success('Tạo phòng thành công');
        return redirect()->route('office.index');
    }

    public function edit($id)
    {
        $office = Office::findOrFail($id);
        $template = "admin.office.office.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/office.css'
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
            'office'
        ));
    }

    public function update(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:offices,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $office->update($validatedData);

        toastr()->success('Cập nhật phòng thành công');
        return redirect()->route('office.index');
    }

    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        toastr()->success('Xóa phòng thành công');
        return redirect()->route('office.index');
    }
}
