<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Sử dụng raw SQL để xóa các unique constraint
        $constraints = [
            'schedules_schedule_date_teacher_id_unique',
            'schedules_schedule_date_class_id_unique', 
            'schedules_schedule_date_room_id_unique',
            'schedules_schedule_date_school_shift_id_unique',
            'schedules_schedule_date_teacher_id_school_shift_id_unique',
            'schedules_teacher_id_schedule_date_unique',
            'schedules_class_id_schedule_date_unique',
            'schedules_room_id_schedule_date_unique'
        ];
        
        foreach ($constraints as $constraint) {
            try {
                \DB::statement("ALTER TABLE schedules DROP INDEX IF EXISTS {$constraint}");
            } catch (Exception $e) {
                // Index không tồn tại, bỏ qua
                echo "Index {$constraint} không tồn tại hoặc đã được xóa\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Không cần rollback vì chúng ta chỉ xóa constraint
        });
    }
};