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
        Schema::create('school_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->nullable(); // Mã của ca học
            $table->string('name', 50); // Tên của ca học
            $table->text('description')->nullable(); // Mô tả chi tiết về ca học
            $table->time('start_time'); // Thời gian bắt đầu của ca học
            $table->time('end_time'); // Thời gian kết thúc của ca học
            $table->date('shift_date'); // Ngày có ca học
            $table->boolean('status')->default(true); // Trạng thái của ca học (true = hoạt động, false = không hoạt động)
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
        Schema::dropIfExists('school_shifts');
    }
};
