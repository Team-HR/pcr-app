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
            $table->smallInteger('order_num')->after('id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_pcr_support_functions', function (Blueprint $table) {
            $table->dropColumn(['order_num']);
        });
    }
};
