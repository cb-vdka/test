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
        Schema::table('training_officer_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_officer_accounts', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropForeign(['faculty_id']);
            $table->dropForeign(['division_id']);
            
            $table->dropColumn(['office_id', 'faculty_id', 'division_id']);
        });
    }
};
