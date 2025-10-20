<?php

namespace Database\Seeders;

use App\Models\StudyStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyStatus::insert([
            [
                'name' => "Đi học (HDI)",
                'description' => ""
            ],
            [
                'name' => "Học lại (HHO)",
                'description' => ""
            ],
            [
                'name' => "Bảo lưu (HBA)",
                'description' => ""
            ],
            [
                'name' => "Nghỉ học (HNG)",
                'description' => ""
            ]
        ]);
    }
}
