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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->nullable();
            $table->string('name', 100);
            $table->string('image')->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 10);
                        // Thông tin bổ sung về giảng viên
            $table->string('address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('cccd_front')->nullable();
            $table->string('cccd_back')->nullable();

            $table->text('bio')->nullable();
            $table->unsignedBigInteger('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->unsignedBigInteger('major_id')->nullable()->constrained('majors')->onDelete('set null');

            $table->unsignedBigInteger('role_id')->nullable()->constrained('roles')->onDelete('set null');
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
        Schema::dropIfExists('teachers');
    }
};
