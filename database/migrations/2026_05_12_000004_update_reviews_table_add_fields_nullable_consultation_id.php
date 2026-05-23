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
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('name')->after('consultation_id');
            $table->string('school')->nullable()->after('name');
            $table->string('class')->nullable()->after('school');
        });

        DB::statement('ALTER TABLE reviews MODIFY consultation_id BIGINT(20) UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE reviews MODIFY consultation_id BIGINT(20) UNSIGNED NOT NULL');

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['name', 'school', 'class']);
        });
    }
};
