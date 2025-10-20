<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::firstOrCreate(
            ['email' => 'admin@dev.local'],
            [
                'name' => 'Admin Dev',
                'email' => 'admin@dev.local',
                'password' => Hash::make('admin123456'),
                'role_id' => 1,
            ]
        );

        Account::firstOrCreate(
            ['email' => 'teacher@dev.local'],
            [
                'name' => 'Teacher Dev',
                'email' => 'teacher@dev.local',
                'password' => Hash::make('teacher123456'),
                'role_id' => 2,
            ]
        );
        
        $this->command->info('✅ Dev accounts ready!');
    }
    }


