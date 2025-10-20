<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::firstOrCreate(
            ['code' => 'TC'],
            [
                'name' => 'Phòng Đào Tạo',
                'description' => 'Phòng quản lý đào tạo',
                'status' => true,
    ]
);
    }
}
