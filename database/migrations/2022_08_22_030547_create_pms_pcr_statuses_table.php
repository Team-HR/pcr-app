<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsPcrStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_pcr_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pms_period_id');
            $table->unsignedBigInteger('sys_employee_id');
            $table->string('immediate_supervisor')->nullable();
            $table->string('department_head')->nullable();
            $table->string('head_of_agency')->nullable();
            $table->unsignedBigInteger('pmt_sys_employee_id')->nullable();
            $table->boolean('is_submitted')->default(0);
            $table->date('date_accomplished')->nullable();
            $table->date('date_approved')->nullable();
            $table->date('date_certified')->nullable();
            $table->date('date_panel_approved')->nullable();
            $table->string('agency');
            $table->string('form_type');
            /**
             * Form Types: 
             * ipcr
             * spcr
             * dspcr
             * dpcr
             */
            $table->unsignedBigInteger('sys_department_id');
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
        Schema::dropIfExists('pms_pcr_statuses');
    }
}
