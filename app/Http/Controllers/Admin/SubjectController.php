<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Models\Courses;
use App\Models\Major;
use App\Models\Subjects;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Services\Interfaces\SubjectServiceInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;
    protected $subjectRepository;

    public function __construct(SubjectServiceInterface $subjectService, SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectService = $subjectService;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $courseId = $request->input('course_id');
        $status = $request->input('status');
        $majorId = $request->input('major_id');

        if ($request->ajax()) {
            $data = $this->subjectService->getSubject($search, $courseId, $status, $majorId);
            return response()->json([
                'data' => view('admin.subject.subject.pages._table', compact('data'))->render(),
                'pagination' => view('admin.subject.subject.pages._pagination', ['data' => $data])->render()
            ]);
        }

        $data = $this->subjectService->getSubject($search, $courseId, $status, $majorId);
        $courses = Courses::all();
        $majors = $this->subjectRepository->getMajors();

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

        $template = "admin.subject.subject.pages.index";

        return view('admin.dashboard.layout', compact(
            'template',
            'data',
            'courses',
            'majors',
            'config'
        ));
    }




    public function create()
    {
        $template = "admin.subject.subject.pages.store";

        $majors = $this->subjectRepository->getMajors();
        // $majors = Major::all();
        $subjectTypes = $this->subjectRepository->getSubjectTypes();
        // Load courses ordered by name for consistent UX
        $departments = Courses::orderBy('name', 'asc')->get();

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
            'majors',
            'subjectTypes',
            'departments',
        ));
    }

    public function store(StoreSubjectRequest $request)
    {
        if ($this->subjectService->create($request)) {
            toastr()->success('Thêm bản ghi thành công!');
            return redirect()->route('subject.index');
        }
        toastr()->success('Thêm bản ghi thất bại!');
        return redirect()->route('subject.index');
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->getSubjectById($id);
        $majors = $this->subjectRepository->getMajors();
        $subjectTypes = $this->subjectRepository->getSubjectTypes();
        $departments = $this->subjectRepository->getCoures();

        $template = "admin.subject.subject.pages.store";
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

        $config['method'] = 'edit';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'subject',
            'majors',
            'subjectTypes',
            'departments'
        ));
    }

    public function getMajorsByCourse(Request $request)
    {
        $courseId = $request->input('course_id');
        $majors = $this->subjectRepository->getMajorsByCourse($courseId);

        return response()->json($majors);
    }

    public function update(Request $request, $id)
    {
        if ($this->subjectService->update($request, $id)) {
            toastr()->success('Chỉnh sửa bảng ghi thành công');
            return redirect()->route('subject.index');
        }
        toastr()->success('Chỉnh sửa bảng ghi thất bại');
        return redirect()->route('subject.index');
    }

    public function destroy($id)
    {
        if ($this->subjectService->destroy($id)) {
            toastr()->success('Xóa bảng ghi thành công');
            return redirect()->route('subject.index');
        }
        toastr()->success('Xóa bảng ghi thất bại');
        return redirect()->route('subject.index');
    }
}