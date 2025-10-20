<?php

namespace Database\Seeders;

use App\Models\Courses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!app()->environment(['local', 'testing'])) {
            return;
        }

        $data = [
            'code' => 'SQDB',
            'name' => 'Đại học',
            'short_name' => 'SQDB',
            'description' => 'Mô tả đối tượng đào tạo SQDB',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => null,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'deleted_at' => null,
        ];

        Courses::firstOrCreate(
            ['code' => $data['code']], // điều kiện kiểm tra trùng
            $data                      // dữ liệu nếu chưa có
        );
    }
}