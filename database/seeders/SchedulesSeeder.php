<?php

namespace Database\Seeders;

use App\Models\Schedules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedules::insert([
            [
                'class_subject_id' => null,
                'room_id' => 1,
                'school_shift_id' => 1, // Added school_shift_id field
                'day_of_week' => 'Monday', // Changed to string as defined in migration
            ],
            [
                'class_subject_id' => null,
                'room_id' => 1,
                'school_shift_id' => 2, // Added school_shift_id field
                'day_of_week' => 'Tuesday', // Changed to string as defined in migration
            ],
            [
                'class_subject_id' => null,
                'room_id' => 1,
                'school_shift_id' => 3, // Added school_shift_id field
                'day_of_week' => 'Tuesday', // Changed to string as defined in migration
            ],   [
                'class_subject_id' => null,
                'room_id' => 1,
                'school_shift_id' => 4, // Added school_shift_id field
                'day_of_week' => 'Tuesday', // Changed to string as defined in migration
            ],   [
                'class_subject_id' => null,
                'room_id' => 1,
                'school_shift_id' => 5, // Added school_shift_id field
                'day_of_week' => 'Tuesday', // Changed to string as defined in migration
            ],
        ]);
    }
}
