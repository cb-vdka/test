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
            // Thay đổi kiểu dữ liệu của school_shift_id từ varchar thành bigint unsigned
            $table->unsignedBigInteger('school_shift_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Đổi lại về varchar
            $table->string('school_shift_id')->change();
        });
    }
};