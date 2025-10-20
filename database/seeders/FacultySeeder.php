<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chỉ chạy khi môi trường là local hoặc testing
        if (!app()->environment(['local', 'testing'])) {
            return;
        }

        $faculties = [
            [
                'code' => 'BCHT',
                'name' => 'Khoa BCHT',
                'description' => 'Bộ môn chiến thuật, Bộ môn Kỹ thuật, Bộ môn Quân sự chung',
                'status' => true,
            ],
        ];

        foreach ($faculties as $faculty) {
            Faculty::firstOrCreate(
                ['code' => $faculty['code']], // điều kiện tìm
                $faculty                      // giá trị để tạo nếu chưa có
            );
        }
    }
}