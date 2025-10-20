<?php

namespace Database\Seeders;

use App\Models\Chats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  TÍNH NĂNG CHAT ĐANG PHÁT TRIỂN - TẠM THỜI DISABLE
        $this->command->warn('⚠️ Tính năng chat đang phát triển !');
        return;
        
        // Code dưới đây sẽ không chạy
        $chats = [
            // ... data
        ];
    }
}
