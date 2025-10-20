<?php

namespace Database\Seeders;

use App\Models\Enrollments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enrollments::insert([
            [
                'student_id' => 1,
                'class_subject_id' => 1,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'student_id' => 2,
                'class_subject_id' => 1,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'student_id' => 3,
                'class_subject_id' => 1,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'student_id' => 4,
                'class_subject_id' => 1,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'student_id' => 5,
                'class_subject_id' => 1,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'student_id' => 2,
                'class_subject_id' => 2,
                'lab_1' => null,
                'lab_2' => null,
                'assignment_1' => null,
                'lab_3' => null,
                'lab_4' => null,
                'assignment_2' => null,
                'final_exam' => null,
                'enrollment_date' => now()->toDateString(),
                'created_by' => 3,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
