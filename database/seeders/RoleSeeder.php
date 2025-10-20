<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Quản Trị Viên',
                'description' => 'Quản trị viên hệ thống',
                'status' => 'active',
                'sort_order' => 1
            ],
            [
                'id' => 2,
                'name' => 'student',
                'display_name' => 'Học Viên',
                'description' => 'Học viên trong hệ thống',
                'status' => 'active',
                'sort_order' => 2
            ],
            [
                'id' => 3,
                'name' => 'teacher',
                'display_name' => 'Giáo Viên',
                'description' => 'Giáo viên trong hệ thống',
                'status' => 'active',
                'sort_order' => 3
            ],
            [
                'id' => 4,
                'name' => 'training_officer',
                'display_name' => 'Cán Bộ Đào Tạo',
                'description' => 'Cán bộ đào tạo trong hệ thống',
                'status' => 'active',
                'sort_order' => 4
            ]
        ];

        foreach ($roles as $roleData) {
            $id = $roleData['id'];
            unset($roleData['id']);
            
            Roles::updateOrCreate(
                ['id' => $id],
                $roleData
            );
        }
    }
}
