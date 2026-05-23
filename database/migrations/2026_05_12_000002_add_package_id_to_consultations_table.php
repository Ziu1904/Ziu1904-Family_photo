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
        if (!Schema::hasColumn('consultations', 'package_id')) {
            Schema::table('consultations', function (Blueprint $table) {
                $table->foreignId('package_id')->nullable()->after('user_id')->constrained('packages')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('consultations', 'package_id')) {
            Schema::table('consultations', function (Blueprint $table) {
                $table->dropConstrainedForeignId('package_id');
            });
        }
    }
};
