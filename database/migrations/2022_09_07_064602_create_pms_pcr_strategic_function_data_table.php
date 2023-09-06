<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsPcrStrategicFunctionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_pcr_strategic_function_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pms_period_id');
            $table->unsignedBigInteger('sys_employee_id');
            $table->text('function_title');
            $table->text('success_indicator');
            $table->text('actual_accomplishment');
            $table->float('final_numerical_rating')->nullable();
            $table->integer('percent')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('not_applicable')->default(false);
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
        Schema::dropIfExists('pms_pcr_strategic_function_data');
    }
}
