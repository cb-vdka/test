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
        Schema::table('schedules', function (Blueprint $table) {
            // Thêm các cột mới
            $table->foreignId('class_id')->nullable()->after('id')->constrained('classes')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->after('class_id')->constrained('subjects')->onDelete('set null');
            
            // Có thể giữ lại class_subject_id để tương thích ngược hoặc xóa nó
            // $table->dropForeign(['class_subject_id']);
            // $table->dropColumn('class_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Xóa các cột đã thêm
            $table->dropForeign(['class_id']);
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['class_id', 'subject_id']);
        });
    }
};