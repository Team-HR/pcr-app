<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsPcrSupportFunctionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_pcr_support_function_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pms_performance_commitment_review_support_function_id");
            $table->unsignedBigInteger("sys_employee_id");
            $table->unsignedBigInteger("pms_period_id");
            $table->string("accomplishment");
            $table->integer("quality")->nullable();
            $table->integer("efficiency")->nullable();
            $table->integer("timeliness")->nullable();
            $table->string("remarks")->nullable();
            $table->string("supervisor_edit")->nullable();
            $table->string("department_head_edit")->nullable();
            $table->string("pmt_edit")->nullable();
            $table->string("critics")->nullable();
            $table->integer("percent");
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
        Schema::dropIfExists('pms_pcr_support_function_data');
    }
}
