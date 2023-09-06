<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsRsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_rsms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("period_id");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->unsignedBigInteger("sys_department_id");
            $table->tinyInteger("index");
            $table->string("code");
            $table->string("title");
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
        Schema::dropIfExists('pms_rsms');
    }
}
