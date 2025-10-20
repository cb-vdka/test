<?php

namespace App\Repositories;

use App\Models\ClassSubject;
use App\Models\Subjects;
use App\Models\Courses;
use App\Repositories\Interfaces\SubjectRegistrationRepositoryInterface;

class SubjectRegistrationRepository extends BaseRepository implements SubjectRegistrationRepositoryInterface
{
    protected $model;

    public function __construct(Subjects $model)
    {
        $this->model = $model;
    }

    public function getCoursesWithSubjects()
    {
        return Courses::all();
    }

    public function getSubjectsWithClasses($courseId)
    {
        return Subjects::where('course_id', $courseId)->get();
    }

    public function getClassesBySubjectId($subjectId)
    {
        return Schedules::where('subject_id', $subjectId)->orderBy('id', 'asc')->get();
    }

    public function getClassData($subjectId)
    {
        return ClassSubject::with(['class', 'teacher'])
            ->where('subject_id', $subjectId)
            ->get();
    }
}
