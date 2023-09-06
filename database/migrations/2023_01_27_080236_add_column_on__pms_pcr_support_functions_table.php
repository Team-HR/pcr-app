<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnPmsPcrSupportFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_pcr_support_functions', function (Blueprint $table) {
            $table->unsignedBigInteger('pms_period_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_pcr_support_functions', function (Blueprint $table) {
            $table->dropColumn(['pms_period_id']);
        });
    }


    

}
