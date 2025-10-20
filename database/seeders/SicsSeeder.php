<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sics;

class SicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sics::insert([
           [
               'class_subject_id' => 1,
               'student_id' => 1,
           ],
            [
                'class_subject_id' => 1,
                'student_id' => 2,
            ],
            [
                'class_subject_id' => 1,
                'student_id' => 3,
            ],
            [
                'class_subject_id' => 1,
                'student_id' => 4,
            ],
            [
                'class_subject_id' => 2,
                'student_id' => 1,
            ],
            [
                'class_subject_id' => 2,
                'student_id' => 1,
            ],
        ]);
    }
}
