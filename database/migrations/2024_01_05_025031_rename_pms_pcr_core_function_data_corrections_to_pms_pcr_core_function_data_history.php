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
        Schema::rename('pms_pcr_core_function_data_corrections', 'pms_pcr_core_function_data_histories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('pms_pcr_core_function_data_histories', 'pms_pcr_core_function_data_corrections');
    }
};
