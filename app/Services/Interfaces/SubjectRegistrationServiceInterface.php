<?php

namespace App\Services\Interfaces;

/**
 * Interface SubjectRegistrationServiceInterface
 * @package App\Services\Interfaces
 */
interface SubjectRegistrationServiceInterface
{
    public function showCourse();
    public function showSubject($id);
    public function showClass($id);
    public function showClassesBySubjectId($subjectId, $studentId);
    public function insertClassData($request);
    public function isClassAlreadyAdded($studentId, $classId);
}
