<?php

namespace Database\Seeders;

use App\Models\TrainingOfficer\TrainingOfficerAccount;
use Illuminate\Database\Seeder;

class TrainingOfficerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrainingOfficerAccount::insert([
            [
                'name' => 'Lữ Phát Huy',
                'email' => 'lphdev04@gmail.com',
                'phone' => '1234567890',
                'address' => '123 Main St, Anytown, USA',
                'hometown' => 'Hometown, USA',
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'name' => 'Lâm Nhật Huy',
                'email' => 'lamnhathuy0393418721@gmail.com',
                'phone' => '1234567890',
                'address' => '123 Main St, Anytown, USA',
                'hometown' => 'Hometown, USA',
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'name' => 'Nguyễn Quốc Huy',
                'email' => 'nguyenquochuy9602@gmail.com',
                'phone' => '1234567890',
                'address' => '123 Main St, Anytown, USA',
                'hometown' => 'Hometown, USA',
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'name' => 'Phạm Anh Hoài',
                'email' => 'phamanhhoaipl@gmail.com',
                'phone' => '1234567890',
                'address' => '123 Main St, Anytown, USA',
                'hometown' => 'Hometown, USA',
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
            [
                'name' => 'Lê Nhựt Thái',
                'email' => 'nhutthai2018@gmail.com',
                'phone' => '1234567890',
                'address' => '123 Main St, Anytown, USA',
                'hometown' => 'Hometown, USA',
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
