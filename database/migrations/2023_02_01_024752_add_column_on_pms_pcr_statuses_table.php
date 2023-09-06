<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnPmsPcrStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_pcr_statuses', function (Blueprint $table) {
            $table->float('overall_numerical_rating')->after('sys_department_id')->nullable()->default(null);
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
            $table->dropColumn(['overall_numerical_rating']);
        });
    }
}
