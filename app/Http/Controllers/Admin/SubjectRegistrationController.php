<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SubjectRegistrationServiceInterface;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;

class SubjectRegistrationController extends Controller
{
    protected $subjectRegistrationService;

    public function __construct(SubjectRegistrationServiceInterface $subjectRegistrationService)
    {
        $this->subjectRegistrationService = $subjectRegistrationService;
    }

    public function getCourse()
    {
        $data = $this->subjectRegistrationService->showCourse();
        $template = "admin.subject_register.course.pages.index";
        $config['seo'] = config('apps.subject_register');
        $breadcrumb = [['title' => 'Danh sách khóa học', 'url' => '']];

        return view('admin.dashboard.layout', compact('template', 'data', 'config', 'breadcrumb'));
    }

    public function getSubject($id)
    {
        $data = $this->subjectRegistrationService->showSubject($id);
        $template = "admin.subject_register.subject.pages.index";
        $config['seo'] = config('apps.subject_register');
        $breadcrumb = [
            ['title' => 'Danh sách khóa học', 'url' => route('get.course')],
            ['title' => 'Danh sách môn học', 'url' => '']
        ];

        return view('admin.dashboard.layout', compact('template', 'data', 'config', 'breadcrumb'));
    }

    public function getClass($id)
    {
        $studentId = session('user_id');
        $data = $this->subjectRegistrationService->showClassesBySubjectId($id, $studentId);
        $template = "admin.subject_register.class.pages.index";
        $config['seo'] = config('apps.subject_register');
        $breadcrumb = [
            ['title' => 'Danh sách khóa học', 'url' => route('get.course')],
            ['title' => 'Danh sách môn học', 'url' => route('get.subject', $id)],
            ['title' => 'Danh sách lớp học', 'url' => '']
        ];

        return view('admin.dashboard.layout', compact('template', 'data', 'config', 'breadcrumb'));
    }

    public function handleInsertClassData(Request $request)
    {
        $studentId = $request->input('student_id');
        $classId = $request->input('class_id');

        if ($this->subjectRegistrationService->isClassAlreadyAdded($studentId, $classId)) {
            toastr()->error('Bạn đã tham gia khóa học này rồi.');
            return redirect()->back();
        }

        if ($this->subjectRegistrationService->insertClassData($request)) {
            toastr()->success('Bạn đã tham gia khóa học thành công');
            return redirect()->back();
        } else {
            toastr()->error('Có lỗi xảy ra khi tham gia khóa học.');
            return redirect()->back();
        }
    }
}
