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
        Schema::table('pms_pcr_core_function_data', function (Blueprint $table) {
            $table->json('changes')->after('not_applicable_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_pcr_core_function_data', function (Blueprint $table) {
            $table->dropColumn(['changes']);
        });
    }
};