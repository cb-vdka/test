<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolShift;
use App\Http\Requests\StoreSchoolShiftRequest;
use App\Http\Requests\UpdateSchoolShiftRequest;
use Illuminate\Http\Request;

class SchoolShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = SchoolShift::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        if ($status !== null) {
            $query->where('status', $status);
        }
        
        $data = $query->orderBy('id', 'desc')->paginate(10);
        
        $template = "admin.school_shift.school_shift.pages.index";
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
        $template = "admin.school_shift.school_shift.pages.store";
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
    public function store(StoreSchoolShiftRequest $request)
    {
        $data = $request->validated();
        
        $schoolShift = new SchoolShift();
        $schoolShift->code = $data['code'];
        $schoolShift->name = $data['name'];
        $schoolShift->description = $data['description'] ?? null;
        $schoolShift->start_time = $data['start_time'];
        $schoolShift->end_time = $data['end_time'];
        $schoolShift->shift_date = $data['shift_date'];
        $schoolShift->status = $data['status'];
        $schoolShift->created_by = session('user_id');
        $schoolShift->save();

        toastr()->success('Thêm ca học thành công');
        return redirect()->route('school_shift.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schoolShift = SchoolShift::findOrFail($id);
        
        $template = "admin.school_shift.school_shift.pages.store";
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
            'schoolShift'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolShiftRequest $request, string $id)
    {
        $data = $request->validated();
        
        $schoolShift = SchoolShift::findOrFail($id);
        $schoolShift->code = $data['code'];
        $schoolShift->name = $data['name'];
        $schoolShift->description = $data['description'] ?? null;
        $schoolShift->start_time = $data['start_time'];
        $schoolShift->end_time = $data['end_time'];
        $schoolShift->shift_date = $data['shift_date'];
        $schoolShift->status = $data['status'];
        $schoolShift->updated_by = session('user_id');
        $schoolShift->save();

        toastr()->success('Cập nhật ca học thành công');
        return redirect()->route('school_shift.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schoolShift = SchoolShift::findOrFail($id);
        $schoolShift->delete();

        toastr()->success('Xóa ca học thành công');
        return redirect()->route('school_shift.index');
    }
}
