<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Class\StoreClassRequest;
use App\Http\Requests\Admin\Class\UpdateClassRequest;
use App\Models\Classes;
use App\Models\ClassSubject;
use App\Models\Courses;
use App\Models\Enrollments;
use App\Models\Major;
use App\Models\Students;
use App\Models\Subjects;
use App\Models\Teachers;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $majorId = $request->input('major_id');
        $query = Classes::withTrashed()->with('major')->orderBy('id','DESC');
        if($search){
            $query->where(
            'name','like',"%{$search}%"
            );
        }
        if($majorId){
            $query->where('major_id',$majorId);
        }

        $classes = $query->paginate($request->input('per_page',10));
        $majors = Major::all();
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];
        
        $template = 'admin.class.class.pages.index';
        return view('admin.dashboard.layout', compact(
            'config',
            'template',
            'classes',
            'majors'
        ));
    }


    public function create()
    {
        $getAllMajor = Major::orderBy('created_at', 'DESC')
            ->get();

        $template = "admin.class.class.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
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
            'getAllMajor',
        ));
    }

    public function store(StoreClassRequest $request)
    {
        try {
            Classes::create([
                'name' => $request->input('name'),
                'major_id' => $request->input('major_id'),
                'description' => $request->input('description'),
                'created_by' => session('user_id')
            ]);
            toastr()->success('Thêm lớp học thành công!');
            return redirect()->route('class.index');
        } catch (\Throwable $e) {
            return back();
        }
    }

    public function edit($id)
    {
        $getEdit =  Classes::where('id', $id)->with(['major:id,name'])->first();
        $getAllMajor = Major::orderBy('created_at', 'DESC')
            ->get();
        $template = "admin.class.class.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
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
            'getEdit',
            'getAllMajor'
        ));
    }

    public function update(UpdateClassRequest $request, $id)
    {
        try {
            $class = Classes::find($id);
            $class->update([
                'name' => $request->input('name'),
                'major_id' => $request->input('major_id'),
                'description' => $request->input('description'),
                'updated_by' => session('user_id')
            ]);
            toastr()->success('Cập nhật lớp học thành công!');
            return redirect()->route('class.index');
        } catch (\Throwable $e) {
            toastr()->error('Có lỗi xảy ra khi cập nhật lớp học!');
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $class = Classes::find($id);
            $class->deleted_by = session('user_id'); //thêm id người xóa vào
            $class->save(); // lưu
            $class->delete(); // xóa mềm
            toastr()->success('Cập nhật lớp học thành công!');
            return redirect()->route('class.index');
        } catch (\Throwable $e) {
            toastr()->error('Có lỗi xảy ra khi cập nhật lớp học!');
            return back();
        }
    }

    public function restore($id)
    {
        $class = Classes::withTrashed()->find($id);
        $class->deleted_by = null;
        $class->save();
        Classes::withTrashed()
            ->where('id', $id)
            ->restore();
        toastr()->success('Khôi phục lớp học thành công!');
        return redirect()->route('class.index');
    }

    public function forceDelete($id)
    {
        Classes::withTrashed()
            ->where('id', $id)
            ->forceDelete();
        toastr()->success('Xóa lớp học thành công!');
        return redirect()->route('class.index');
    }

    /**
     * Hiển thị form thêm sinh viên vào lớp
     */
    public function addStudents($id)
    {
        $class = Classes::with('major')->find($id);
        
        if (!$class) {
            toastr()->error('Lớp không tồn tại!');
            return redirect()->route('class.index');
        }

        // Lấy danh sách class_subject của lớp này
        $classSubjects = ClassSubject::where('class_id', $id)->get();
        
        // Lấy danh sách sinh viên đã đăng ký vào lớp này
        $enrolledStudentIds = Enrollments::whereIn('class_subject_id', $classSubjects->pluck('id'))
            ->pluck('student_id')
            ->unique();

        $enrolledStudents = Students::whereIn('id', $enrolledStudentIds)
            ->with(['major', 'course'])
            ->get();

        // Lấy danh sách sinh viên chưa đăng ký vào lớp này
        $availableStudents = Students::whereNotIn('id', $enrolledStudentIds)
            ->with(['major', 'course'])
            ->get();

        $template = 'admin.class.class.pages.add_students';
        
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/class.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'class',
            'enrolledStudents',
            'availableStudents',
            'classSubjects'
        ));
    }

    /**
     * Lưu sinh viên vào lớp
     */
    public function storeStudents(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id'
        ], [
            'student_ids.required' => 'Vui lòng chọn ít nhất một sinh viên',
            'student_ids.array' => 'Dữ liệu sinh viên không hợp lệ',
            'student_ids.min' => 'Vui lòng chọn ít nhất một sinh viên',
            'student_ids.*.exists' => 'Một hoặc nhiều sinh viên không tồn tại'
        ]);

        try {
            $class = Classes::find($id);
            if (!$class) {
                toastr()->error('Lớp không tồn tại!');
                return redirect()->route('class.index');
            }

            // Lấy danh sách class_subject của lớp này
            $classSubjects = ClassSubject::where('class_id', $id)->get();
            
            if ($classSubjects->isEmpty()) {
                toastr()->error('Lớp này chưa có môn học nào. Vui lòng thêm môn học trước!');
                return redirect()->route('class.index');
            }

            $studentIds = $request->student_ids;
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($studentIds as $studentId) {
                foreach ($classSubjects as $classSubject) {
                    // Kiểm tra xem sinh viên đã đăng ký môn này chưa
                    $existingEnrollment = Enrollments::where('student_id', $studentId)
                        ->where('class_subject_id', $classSubject->id)
                        ->first();

                    if (!$existingEnrollment) {
                        // Tạo enrollment mới
                        Enrollments::create([
                            'student_id' => $studentId,
                            'class_subject_id' => $classSubject->id,
                            'enrollment_date' => now(),
                            'created_by' => session('user_id')
                        ]);
                        $successCount++;
                    } else {
                        $errorCount++;
                        $student = Students::find($studentId);
                        $subject = $classSubject->subject;
                        $errors[] = "Sinh viên {$student->name} đã đăng ký môn {$subject->name}";
                    }
                }
            }

            if ($successCount > 0) {
                toastr()->success("Đã thêm {$successCount} đăng ký thành công!");
            }
            
            if ($errorCount > 0) {
                toastr()->warning("Có {$errorCount} đăng ký bị trùng lặp hoặc lỗi!");
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        toastr()->info($error);
                    }
                }
            }

            return redirect()->route('class.index');

        } catch (\Exception $e) {
            toastr()->error('Có lỗi xảy ra: ' . $e->getMessage());
            return back();
        }
    }
}
