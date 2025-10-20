<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::firstOrCreate(
            ['name' => 'Demo'],
            [
                'description' => 'Phòng Học Demo',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
    ]
);

    }
}
