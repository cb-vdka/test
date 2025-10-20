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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->nullable()->constrained('class_subjects')->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained('classrooms')->onDelete('set null');
            $table->unsignedBigInteger('school_shift_id');
            $table->string('day_of_week'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
