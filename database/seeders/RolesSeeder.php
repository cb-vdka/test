<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;
use DateTime;
use Illuminate\Support\Facades\Date;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::insert([
            [
                'name' => 'Admin',
                'description' => 'Quản Lý Toàn Bộ Website',
            ],
            [
                'name' => 'Student',
                'description' => 'Tham Gia Khóa Học, Xem Điểm, Xem Lớp Học Và Đánh Giá Giáo Viên',
            ],
            [
                'name' => 'Teacher',
                'description' => 'Xem Lịch Dạy, Nhập Điểm, Điểm Danh',
            ],
            [
                'name' => 'Training Officer',
                'description' => 'Sắp Xếp Lịch Huấn Luyện, Giải Đáp Thắc Mắc Của Sinh Viên',
            ],
        ]);
    }
}
