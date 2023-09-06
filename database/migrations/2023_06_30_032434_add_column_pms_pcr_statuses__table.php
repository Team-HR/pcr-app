<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPmsPcrStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_pcr_statuses', function (Blueprint $table) {
            $table->bigInteger('sys_position_id')->after('sys_department_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_pcr_statuses', function (Blueprint $table) {
            $table->dropColumn(['sys_position_id']);
        });
    }
}
