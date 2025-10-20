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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->unsignedBigInteger('class_subject_id')->nullable()->constrained('class_subjects')->onDelete('set null');
            $table->double('lab_1')->nullable();
            $table->double('lab_2')->nullable();
            $table->double('assignment_1')->nullable();
            $table->double('lab_3')->nullable();
            $table->double('lab_4')->nullable();
            $table->double('assignment_2')->nullable();
            $table->double('final_exam')->nullable();
            $table->date('enrollment_date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
