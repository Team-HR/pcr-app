<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOnSysEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_employees', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('ext');
            $table->boolean('is_employee')->default(1)->after('gender');
            $table->boolean('is_active')->default(1)->after('is_employee');
            $table->string('remarks')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_employees', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'gender', 'is_employee', 'remarks']);
        });
    }
}
