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
        Schema::create('pl_hdtl1_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->enum('file_type', ['kqhttx', 'kqrl', 'ngay_cong', 'dieu_chinh', 'ren_luyen_kha', 'hoc_gioi']); // Các loại file
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size');
            $table->string('file_extension'); // xlsx, xls, pdf
            $table->enum('status', ['public', 'hidden'])->default('hidden');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['class_id', 'file_type', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_hdtl1_files');
    }
};
