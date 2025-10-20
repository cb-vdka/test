<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các roles
        $adminRole = Roles::where('name', 'Admin')->first();
        $teacherRole = Roles::where('name', 'Teacher')->first();
        $studentRole = Roles::where('name', 'Student')->first();
        $trainingOfficerRole = Roles::where('name', 'Training Officer')->first();

        // Permissions cho Admin (tất cả quyền)
        if ($adminRole) {
            $allPermissions = Permission::all();
            $adminRole->permissions()->sync($allPermissions->pluck('id'));
        }

        // Permissions cho Teacher
        if ($teacherRole) {
            $teacherPermissions = [
                'dashboard.view',
                'schedule.view',
                'schedule.create',
                'schedule.edit',
                'enrollment.view',
                'enrollment.edit',
                'evaluation.view',
                'evaluation.create',
                'evaluation.edit',
                'chat.view',
                'chat.send',
                'report.view',
            ];
            
            $permissionIds = Permission::whereIn('name', $teacherPermissions)->pluck('id');
            $teacherRole->permissions()->sync($permissionIds);
        }

        // Permissions cho Student
        if ($studentRole) {
            $studentPermissions = [
                'dashboard.view',
                'schedule.view',
                'enrollment.view',
                'evaluation.view',
                'chat.view',
                'chat.send',
            ];
            
            $permissionIds = Permission::whereIn('name', $studentPermissions)->pluck('id');
            $studentRole->permissions()->sync($permissionIds);
        }

        // Permissions cho Training Officer
        if ($trainingOfficerRole) {
            $trainingOfficerPermissions = [
                'dashboard.view',
                'student.view',
                'student.create',
                'student.edit',
                'student.export',
                'teacher.view',
                'teacher.create',
                'teacher.edit',
                'teacher.export',
                'course.view',
                'course.create',
                'course.edit',
                'subject.view',
                'subject.create',
                'subject.edit',
                'class.view',
                'class.create',
                'class.edit',
                'schedule.view',
                'schedule.create',
                'schedule.edit',
                'enrollment.view',
                'enrollment.create',
                'enrollment.edit',
                'enrollment.export',
                'evaluation.view',
                'evaluation.create',
                'evaluation.edit',
                'chat.view',
                'chat.send',
                'report.view',
                'report.export',
            ];
            
            $permissionIds = Permission::whereIn('name', $trainingOfficerPermissions)->pluck('id');
            $trainingOfficerRole->permissions()->sync($permissionIds);
        }
    }
}