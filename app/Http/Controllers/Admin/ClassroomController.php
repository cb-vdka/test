<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = Classroom::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        if ($status !== null) {
            $query->where('status', $status);
        }
        
        $data = $query->orderBy('id', 'desc')->paginate(10);
        
        $template = "admin.classroom.classroom.pages.index";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
        
        return view('admin.dashboard.layout', compact(
            'template',
            'data',
            'config'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = "admin.classroom.classroom.pages.store";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
        $config['method'] = 'create';
        
        return view('admin.dashboard.layout', compact(
            'template',
            'config'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassroomRequest $request)
    {
        $data = $request->validated();
        
        $classroom = new Classroom();
        $classroom->name = $data['name'];
        $classroom->description = $data['description'] ?? null;
        $classroom->status = $data['status'];
        $classroom->created_by = session('user_id');
        $classroom->save();

        toastr()->success('Thêm địa điểm học thành công');
        return redirect()->route('classroom.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::findOrFail($id);
        
        $template = "admin.classroom.classroom.pages.store";
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
        $config['method'] = 'edit';
        
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'classroom'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomRequest $request, string $id)
    {
        $data = $request->validated();
        
        $classroom = Classroom::findOrFail($id);
        $classroom->name = $data['name'];
        $classroom->description = $data['description'] ?? null;
        $classroom->status = $data['status'];
        $classroom->updated_by = session('user_id');
        $classroom->save();

        toastr()->success('Cập nhật địa điểm học thành công');
        return redirect()->route('classroom.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        toastr()->success('Xóa địa điểm học thành công');
        return redirect()->route('classroom.index');
    }
}
