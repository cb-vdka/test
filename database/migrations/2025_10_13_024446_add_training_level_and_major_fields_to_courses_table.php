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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('training_level', 100)->nullable()->after('name')->comment('Trình độ đào tạo');
            // $table->string('major_name', 255)->nullable()->after('training_level')->comment('Ngành đào tạo');
            $table->string('major_code', 50)->nullable()->after('major_name')->comment('Mã ngành');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['training_level', 'major_name', 'major_code']);
        });
    }
};
