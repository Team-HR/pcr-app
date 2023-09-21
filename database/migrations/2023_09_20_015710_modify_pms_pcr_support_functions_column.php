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
        Schema::table('pms_pcr_support_functions', function (Blueprint $table) {
            $table->json("quality")->default("[]")->change();
            $table->json("efficiency")->default("[]")->change();
            $table->json("timeliness")->default("[]")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_pcr_support_functions', function (Blueprint $table) {
            $table->json("quality")->nullable()->change();
            $table->json("efficiency")->nullable()->change();
            $table->json("timeliness")->nullable()->change();
        });
    }
};
