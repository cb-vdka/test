<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chỉ chạy khi ở môi trường local hoặc testing
        if (!app()->environment(['local', 'testing'])) {
            return;
        }

        $data = [
            'name' => 'QD101',
            'description' => 'Lớp quân sự cơ sở',
            'major_id' => 1,
            'created_by' => 3,
            'created_at' => now(),
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null,
        ];

        Classes::firstOrCreate(
            ['name' => $data['name']], // Điều kiện kiểm tra trùng
            $data                      // Dữ liệu nếu chưa có
        );
    }
}