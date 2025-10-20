<?php

namespace App\Repositories\Interfaces;

/**
 * Interface BaseRepositoryInterface
 * @package App\Reponsitories\Interfaces
 */
interface SubjectRegistrationRepositoryInterface
{
    public function getCoursesWithSubjects();
    public function getSubjectsWithClasses($courseId);
    public function getClassesBySubjectId($subjectId);
    public function getClassData($id);

}
