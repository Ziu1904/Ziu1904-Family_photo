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
        Schema::table('consultations', function (Blueprint $table) {
            if (! Schema::hasColumn('consultations', 'class_name')) {
                $table->string('class_name')->nullable()->after('package_id');
            }
            if (! Schema::hasColumn('consultations', 'phone')) {
                $table->string('phone')->nullable()->after('class_name');
            }
            if (! Schema::hasColumn('consultations', 'area')) {
                $table->string('area')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('consultations', 'note')) {
                $table->text('note')->nullable()->after('time');
            }
        });

        // Allow unauthenticated consultation requests when user_id is not available.
        DB::statement('ALTER TABLE consultations MODIFY user_id BIGINT UNSIGNED NULL');

        // Store request time as string since booking form may send descriptive ranges.
        DB::statement('ALTER TABLE consultations MODIFY time VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
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

        DB::statement('ALTER TABLE consultations MODIFY user_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE consultations MODIFY time DATETIME NOT NULL');
    }
};
