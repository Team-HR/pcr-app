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
        Schema::create('pms_pcr_core_function_data_correction_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pms_pcr_core_function_data_id');
            $table->text('correction_comments');
            $table->unsignedBigInteger('created_by_sys_employee_id');
            $table->text('created_by_type'); //supervisor/department_head/pmt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_pcr_core_function_data_correction_comments');
    }
};
