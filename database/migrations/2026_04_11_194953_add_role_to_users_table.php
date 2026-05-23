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
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'manager', 'user'])->default('user')->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone', 20)->nullable()->after('role');
            });
        }

        if (!Schema::hasColumn('users', 'school')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('school')->nullable()->after('phone');
            });
        }

        if (!Schema::hasColumn('users', 'class')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('class')->nullable()->after('school');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'school', 'class']);
        });
    }
};
