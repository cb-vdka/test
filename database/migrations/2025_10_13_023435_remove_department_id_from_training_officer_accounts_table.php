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
            // Check if foreign key exists before dropping
            if (Schema::hasColumn('training_officer_accounts', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_officer_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('hometown');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }
};
