<?php
namespace Database\Seeders;

use App\Models\Teachers;
use App\Models\Major;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map major by course to ensure valid foreign key
        $majorByCourse = Major::select('id', 'course_id')
            ->get()
            ->groupBy('course_id')
            ->map(function ($items) {
                return optional($items->first())->id;
            });

        $teachers = [           
            [
                'code' => '0000',
                'name' => 'Nguyễn Vũ Dương',
                'email' => 'nguyenvuduong@gmail.com',
                'phone' => '0945567048',
                'address' => 'Phu Tho, Viet Nam',
                'current_address' => 'Phu Tho, Viet Nam',
                'gender' => 'Male',
                'date_of_birth' => '1980-01-01',
                'qualifications' => 'Cu nhan',
                'cccd_front' => null,
                'cccd_back' => null,
                'bio' => null,
                'course_id' => 1,
                'major_id' => $majorByCourse->get(1),
                'role_id' => 3,
                'OTP' => rand(111111, 999999),
                'created_by' => null,
                'created_at' => null,
                'updated_by' => null,
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null,
            ],
        ];

        foreach ($teachers as $t) {
            // Idempotent upsert by unique email
            Teachers::firstOrCreate(
                ['email' => $t['email']],
                $t
            );
        }
    }
}

