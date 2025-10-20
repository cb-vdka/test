<?php

namespace App\Services;

use App\Models\Enrollments;
use App\Repositories\SubjectRegistrationRepository;
use App\Services\Interfaces\SubjectRegistrationServiceInterface;
use Illuminate\Support\Carbon;

class SubjectRegistrationService implements SubjectRegistrationServiceInterface
{
    protected $subjectRegistrationRepository;

    public function __construct(SubjectRegistrationRepository $subjectRegistrationRepository)
    {
        $this->subjectRegistrationRepository = $subjectRegistrationRepository;
    }

    public function showCourse()
    {
        try {
            return $this->subjectRegistrationRepository->getCoursesWithSubjects();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function showSubject($id)
    {
        try {
            return $this->subjectRegistrationRepository->getSubjectsWithClasses($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function showClass($id)
    {
        try {
            return $this->subjectRegistrationRepository->getClassesBySubjectId($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function showClassesBySubjectId($subjectId, $studentId)
    {
        try {
            $classes = $this->subjectRegistrationRepository->getClassData($subjectId);

            foreach ($classes as $class) {
                $class->is_joined = $this->isClassAlreadyAdded($studentId, $class->id);
            }

            return $classes;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertClassData($request)
    {
        try {
            $payload = [
                'student_id' => $request->input('student_id'),
                'class_id' => $request->input('class_id'),
                'enrollment_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => null
            ];

            Enrollments::create($payload);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isClassAlreadyAdded($studentId, $classId)
    {
        try {
            return Enrollments::where('student_id', $studentId)
                ->where('class_id', $classId)
                ->exists();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
