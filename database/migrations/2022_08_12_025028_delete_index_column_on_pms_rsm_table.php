<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIndexColumnOnPmsRsmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_rsms', function (Blueprint $table) {
            $table->dropColumn('index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_rsms', function (Blueprint $table) {
            $table->integer("index")->after("sys_department_id")->default(0);
        });
    }
}
