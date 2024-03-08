<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsPcrCoreFunctionDataHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_pcr_core_function_data_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pms_pcr_core_function_data_id');
            $table->text('actual');
            $table->integer('quality')->nullable();
            $table->integer('efficiency')->nullable();
            $table->integer('timeliness')->nullable();
            $table->integer('percent')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('not_applicable')->default(false);
            $table->text('not_applicable_remarks')->nullable();
            $table->unsignedBigInteger('created_by_sys_employee_id');
            $table->text('created_by_type'); //supervisor/department_head/pmt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pms_pcr_core_function_data_histories');
    }
}
