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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Tự động tạo khóa chính với tên là 'id'
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('subject_type_id');
            $table->unsignedBigInteger('course_id');
            $table->string('code');
            $table->string('name');
            $table->integer('credit_num');
            $table->integer('total_class_session');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
