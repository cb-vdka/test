<?php

namespace Database\Seeders;

use App\Models\ClassSubject;
use App\Models\SubjectType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            SchoolShiftSeeder::class,
            ClassroomSeeder::class,
            MajorSeeder::class,
            CoursesSeeder::class,
            SubjectsSeeder::class,
            
            // Permissions and role-permissions
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            AccountSeeder::class,
            OfficeSeeder::class,
            FacultySeeder::class,
            DivisionSeeder::class,
            TrainingOfficerAccountSeeder::class,
            TeachersSeeder::class,
            ClassesSeeder::class,
            SchedulesSeeder::class,
            EnrollmentsSeeder::class,
            ChatsSeeder::class,
            SubjectTypeSeeder::class,
            StudyStatusSeeder::class,
            StudentsSeeder::class,
            ClassSubjectSeeder::class,
            SicsSeeder::class
        ]);
    }
}
