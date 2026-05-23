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
        if (Schema::hasColumn('albums', 'booking_id') && !Schema::hasColumn('albums', 'package_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropForeign(['booking_id']);
            });

            DB::statement('ALTER TABLE `albums` CHANGE `booking_id` `package_id` BIGINT UNSIGNED NOT NULL');

            Schema::table('albums', function (Blueprint $table) {
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            });
        }

        if (Schema::hasColumn('albums', 'consultation_id') && !Schema::hasColumn('albums', 'package_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropForeign(['consultation_id']);
            });

            DB::statement('ALTER TABLE `albums` CHANGE `consultation_id` `package_id` BIGINT UNSIGNED NOT NULL');

            Schema::table('albums', function (Blueprint $table) {
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('albums', 'package_id') && !Schema::hasColumn('albums', 'booking_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropForeign(['package_id']);
            });

            DB::statement('ALTER TABLE `albums` CHANGE `package_id` `booking_id` BIGINT UNSIGNED NOT NULL');

            Schema::table('albums', function (Blueprint $table) {
                $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            });
        }
    }
};