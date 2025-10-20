<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;

class SetupPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup permissions and roles for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up permissions and roles...');
        
        // Chạy PermissionSeeder
        $this->info('Creating permissions...');
        $this->call('db:seed', ['--class' => PermissionSeeder::class]);
        
        // Chạy RolePermissionSeeder
        $this->info('Setting up role permissions...');
        $this->call('db:seed', ['--class' => RolePermissionSeeder::class]);
        
        $this->info('Permissions and roles setup completed successfully!');
    }
}

