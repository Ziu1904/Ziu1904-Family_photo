<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('consultations', 'manager_response')) {
            Schema::table('consultations', function (Blueprint $table) {
                $table->text('manager_response')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('manager_response');
        });
    }
};
