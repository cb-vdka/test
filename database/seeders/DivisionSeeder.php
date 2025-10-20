<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chỉ chạy ở môi trường local hoặc testing
        if (!app()->environment(['local', 'testing'])) {
            return;
        }

        $data = [
            'code' => 'QL',
            'name' => 'Ban Quân lực',
            'description' => 'Trưởng ban, Trợ lý, Nhân viên Thống kê, hồ sơ',
            'status' => true,
        ];

        Division::firstOrCreate(
            ['code' => $data['code']], // điều kiện kiểm tra trùng
            $data                      // dữ liệu nếu chưa tồn tại
        );
    }
}
