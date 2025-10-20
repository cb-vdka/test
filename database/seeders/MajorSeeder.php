<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Major::firstOrCreate(
            ['code' => 'DEMO'], // kiểm tra tồn tại theo code
            [
                'name' => "Tiểu đội trưởng bộ bin",
                'standard' => "3 tháng",
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'course_id' => 1,
            ]
        );
        
    }
}
