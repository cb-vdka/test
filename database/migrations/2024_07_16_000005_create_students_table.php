<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('student_code', 7)->unique();
            $table->tinyInteger('gender');
            $table->timestamp('date_of_birth')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('email', 100)->unique();
            $table->string('password', 255)->nullable();
            $table->string('address', 200);
            $table->unsignedBigInteger('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->unsignedBigInteger('major_id')->nullable()->constrained('majors')->onDelete('set null');
            $table->string('cccd_number',20);
            $table->timestamp('cccd_issue_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('cccd_place', 100);
            $table->timestamp('year_of_enrollment')->nullable();
            $table->unsignedBigInteger('study_status_id')->nullable()->constrained('study_statuses')->onDelete('set null');
            $table->string('semesters');
            $table->string('phone', 15);
            $table->unsignedBigInteger('role_id')->nullable()->constrained('roles')->onDelete('set null')->default(2);
            $table->string('OTP');
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
        Schema::dropIfExists('students');
    }
};