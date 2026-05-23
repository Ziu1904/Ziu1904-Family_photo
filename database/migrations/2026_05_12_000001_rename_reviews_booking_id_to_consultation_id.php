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
        if (Schema::hasColumn('reviews', 'booking_id') && !Schema::hasColumn('reviews', 'consultation_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropForeign(['booking_id']);
            });

            DB::statement('ALTER TABLE `reviews` CHANGE `booking_id` `consultation_id` BIGINT UNSIGNED NOT NULL');

            Schema::table('reviews', function (Blueprint $table) {
                $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('reviews', 'consultation_id') && !Schema::hasColumn('reviews', 'booking_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropForeign(['consultation_id']);
            });

            DB::statement('ALTER TABLE `reviews` CHANGE `consultation_id` `booking_id` BIGINT UNSIGNED NOT NULL');

            Schema::table('reviews', function (Blueprint $table) {
                $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            });
        }
    }
};
