<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEmployeeAssignedDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_employee_assigned_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sys_department_id');
            $table->unsignedBigInteger('sys_employee_id');
            $table->boolean('is_current')->default(1);
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
        Schema::dropIfExists('sys_employee_assigned_departments');
    }
}
