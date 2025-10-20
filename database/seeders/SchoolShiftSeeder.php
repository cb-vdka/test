<?php

namespace Database\Seeders;

use App\Models\SchoolShift;
use Illuminate\Database\Seeder;

class SchoolShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolShift::insert([
            [
                'code' => 'DEMO',
                'name' => 'DEMO Tiết học',
                'description' => 'DEMO Tiết học',
                'start_time' => '01:00:00',
                'end_time' => '01:10:00',
                'shift_date' => null,
                'status' => true,
            ],
        ]);
    }
}
