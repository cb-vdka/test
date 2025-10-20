<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\TrainingOfficer\TrainingOfficerAccount;
use App\Models\TeachingMaterial;
use Illuminate\Http\Request;

class TeachingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = TeachingMaterial::with('officer', 'course');

        if ($request->has('course_id') && !empty($request->course_id)) {
            $query->where('course_id', $request->course_id);
        }

        $materials = $query->get();
        $courses = Courses::all(); // Fetch all courses for the dropdown

        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teachermaterials.pages.index'
        ], compact('materials', 'courses'));
    }

    public function create()
    {
        $materials = TeachingMaterial::with('officer')->get();
        $officers = TrainingOfficerAccount::all(); // Fetch all officers
        $courses = Courses::all(); // Fetch all courses
        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teachermaterials.pages.store'
        ], compact('materials', 'officers', 'courses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'officer_id' => 'required|exists:training_officer_accounts,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_link' => 'required|url',
        ]);

        TeachingMaterial::create([
            'officer_id' => $request->officer_id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $request->file_link,
        ]);

        toastr()->success('Tài liệu giảng dạy đã được tải lên thành công.');
        return redirect()->route('materials.index');
    }


    public function show(TeachingMaterial $teachingMaterial)
    {
        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teachermaterials.pages.show'
        ], compact('teachingMaterial'));
    }
    public function edit($id)
    {
        $teachingMaterial = TeachingMaterial::findOrFail($id);
        $officers = TrainingOfficerAccount::all();
        $courses = Courses::all();
        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teachermaterials.pages.edit'
        ], compact('teachingMaterial', 'officers', 'courses'));
    }
    public function update(Request $request, $id)
    {
        $teachingMaterial = TeachingMaterial::findOrFail($id);
        $teachingMaterial->update([
            'officer_id' => $request->officer_id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $request->file_link,
        ]);
        toastr()->success('Tài liệu giảng dạy đã được cập nhật thành công.');
        return redirect()->route('materials.index');
    }
    public function destroy($id)
    {
        $teachingMaterial = TeachingMaterial::findOrFail($id);
        $teachingMaterial->delete();

        toastr()->success('Tài liệu giảng dạy đã được xóa thành công.');
        return redirect()->route('materials.index');
    }
}
