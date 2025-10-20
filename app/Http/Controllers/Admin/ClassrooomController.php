<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Classroom\StoreClassroomRequest;
use App\Http\Requests\Admin\Classroom\UpdateClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassrooomController extends Controller
{
    protected $province;

    public function __construct()
    {
        $this->province = new Classroom();
    }

    public function index(Request $request)
    {
        $sort = 10;

        $filter = $request->search;

        if (!empty($request->sort)) {
            $sort = $request->sort;
        }

        $getAllClassroom = $this->province::where('name', 'LIKE', '%' . $filter . '%')->paginate($sort);

        $template = "admin.classroom.classroom.pages.index";

        return view('admin.dashboard.layout', compact('template', 'getAllClassroom'));
    }

    public function create(Request $request)
    {
        $template = "admin.classroom.classroom.pages.store";

        $config['method'] = 'create';

        return view('admin.dashboard.layout', compact('template', 'config'));
    }

    public function store(StoreClassroomRequest $request)
    {
        $data = $request->validated();

        if ($data) {
            
            $classroom = $this->province;

            $classroom->name = $data['name'];

            $classroom->description = $data['description'];

            $classroom->status = $data['status'];

            $classroom->save();

            toastr()->success('Thêm địa điểm học thành công');

            return redirect()->route('classroom.index');
        }

        toastr()->success('Đã xảy ra lỗi');

        return back();
    }

    public function edit(Request $request, $id)
    {
        $getEdit = $this->province::find($id);

        $request->session()->put('classroom_id_edit', $id);

        $config['method'] = 'edit';

        $template = 'admin.classroom.classroom.pages.store';

        return view('admin.dashboard.layout', compact('getEdit', 'template', 'config'));
    }

    public function update(UpdateClassroomRequest $request)
    {
        $data = $request->validated();

        if ($data) {

            $classroom = $this->province::find(session('classroom_id_edit'));

            $classroom->name = $data['name'];

            $classroom->description = $data['description'];

            $classroom->status = $data['status'];

            $classroom->save();

            toastr()->success('Cập nhật địa điểm học thành công');

            return redirect()->route('classroom.index');
        }

        toastr()->success('Đã xảy ra lỗi');

        return back();
    }

    public function trash($id)
    {
        $trash = $this->province::find($id);

        $trash->deleted_by = session('user_id');

        $trash->deleted_at = now();

        $trash->save();

        toastr()->success('Đã Ẩn địa điểm học');

        return redirect()->route('classroom.index');
    }

    public function restore($id)
    {
        $restore = $this->province::find($id);

        $restore->deleted_by = null;

        $restore->deleted_at = null;

        $restore->save();

        toastr()->success('Đã Khôi Phục địa điểm học');

        return redirect()->route('classroom.index');
    }

    public function delete($id)
    {
        $delete = $this->province::find($id);

        $delete->delete();

        toastr()->success('Đã Xóa địa điểm học');

        return redirect()->route('classroom.index');
    }
}
