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
            $table->unsignedBigInteger('created_by_sys_employee_id')->after('not_applicable_remarks');
            $table->text('created_by_type')->after('created_by_sys_employee_id')->default('usr'); //usr/sup/dh/pmt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_pcr_core_function_data', function (Blueprint $table) {
            $table->dropColumn(['created_by_sys_employee_id', 'created_by_type']);
        });
    }
};
