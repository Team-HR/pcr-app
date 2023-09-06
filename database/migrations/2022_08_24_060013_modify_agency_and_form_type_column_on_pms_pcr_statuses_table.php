<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAgencyAndFormTypeColumnOnPmsPcrStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_pcr_statuses', function (Blueprint $table) {
            $table->string('agency')->nullable()->change();
            $table->string('form_type')->nullable()->change();
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
            $table->string('agency')->change();
            $table->string('form_type')->change();
        });
    }
}
