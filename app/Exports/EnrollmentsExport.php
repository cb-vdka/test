<?php
// app/Exports/EnrollmentsExport.php
namespace App\Exports;

use App\Models\Enrollments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnrollmentsExport implements FromCollection, WithHeadings
{
    protected $classId;

    public function __construct($classId)
    {
        $this->classId = $classId;
    }

    public function collection()
    {
        return Enrollments::select('student_id', 'lab_1', 'lab_2', 'lab_3', 'lab_4', 'assignment_1', 'assignment_2', 'final_exam', 'class_subject_id')
            ->where('class_subject_id', $this->classId)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Lab 1',
            'Lab 2',
            'Lab 3',
            'Lab 4',
            'Assignment 1',
            'Assignment 2',
            'Final Exam',
            'Class Subject ID',
        ];
    }
}
