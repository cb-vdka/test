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
        Schema::table('score_sheets', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['uploaded_by']);
            
            // Make uploaded_by nullable
            $table->unsignedBigInteger('uploaded_by')->nullable()->change();
            
            // Re-add foreign key constraint with onDelete('set null')
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('score_sheets', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['uploaded_by']);
            
            // Make uploaded_by not nullable
            $table->unsignedBigInteger('uploaded_by')->nullable(false)->change();
            
            // Re-add foreign key constraint
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
