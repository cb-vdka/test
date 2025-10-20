<?php

namespace Database\Seeders;

use App\Models\Subjects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subjects::insert([
            [
                'major_id' => 1,
                'subject_type_id' => 1,
                'course_id' => 1,
                'code' => "00001",
                'name' => "Demo",
                'credit_num' => 3,
                'total_class_session' => 30,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
