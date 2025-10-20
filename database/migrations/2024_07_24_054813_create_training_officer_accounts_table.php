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
        Schema::create('training_officer_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Tên của cán bộ quản lý
            $table->string('email', 100)->unique();
            $table->string('phone', 15)->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Địa chỉ hiện tại
            $table->string('hometown')->nullable(); // Quê quán
            $table->unsignedBigInteger('role_id')->nullable()->constrained('roles')->onDelete('set null')->default(4);
            $table->integer('OTP')->nullable();
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
        Schema::dropIfExists('training_officer_accounts');
    }
};
