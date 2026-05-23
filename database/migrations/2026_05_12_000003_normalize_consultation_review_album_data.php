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
        if (Schema::hasColumn('consultations', 'package_id')) {
            DB::statement("UPDATE consultations SET status = 'confirmed' WHERE status IN ('in-progress', 'contacted')");
            DB::statement("UPDATE consultations SET status = 'cancelled' WHERE status = 'rejected'");

            if (Schema::hasColumn('consultations', 'class_name') && Schema::hasColumn('bookings', 'class')) {
                DB::statement(
                    "UPDATE consultations c
                     JOIN bookings b ON c.user_id = b.user_id AND c.class_name = b.class
                     SET c.package_id = b.package_id
                     WHERE c.package_id IS NULL"
                );
            }
        }

        if (Schema::hasColumn('reviews', 'booking_id') && Schema::hasColumn('consultations', 'user_id')) {
            DB::statement(
                "UPDATE reviews r
                 JOIN bookings b ON r.booking_id = b.id
                 JOIN consultations c ON c.user_id = b.user_id AND c.class_name = b.class
                 SET r.consultation_id = c.id
                 WHERE r.consultation_id IS NULL"
            );
        }

        if (Schema::hasColumn('consultations', 'class_name') || Schema::hasColumn('consultations', 'phone') || Schema::hasColumn('consultations', 'area') || Schema::hasColumn('consultations', 'note')) {
            Schema::table('consultations', function (Blueprint $table) {
                if (Schema::hasColumn('consultations', 'class_name')) {
                    $table->dropColumn('class_name');
                }
                if (Schema::hasColumn('consultations', 'phone')) {
                    $table->dropColumn('phone');
                }
                if (Schema::hasColumn('consultations', 'area')) {
                    $table->dropColumn('area');
                }
                if (Schema::hasColumn('consultations', 'note')) {
                    $table->dropColumn('note');
                }
            });
        }

        if (Schema::hasColumn('reviews', 'booking_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropForeign(['booking_id']);
                $table->dropColumn('booking_id');
            });
        }

        if (Schema::hasColumn('albums', 'booking_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropForeign(['booking_id']);
                $table->dropColumn('booking_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This normalization migration is intentionally irreversible.
    }
};
