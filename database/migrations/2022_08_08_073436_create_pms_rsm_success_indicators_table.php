<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsRsmSuccessIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_rsm_success_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pms_rsm_id");
            $table->integer("index")->default(0);
            $table->string("success_indicator");
            $table->json("quality")->nullable();
            $table->json("efficiency")->nullable();
            $table->json("timeliness")->nullable();
            $table->json("in_charges")->nullable();
            $table->json("corrections")->nullable();
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
        Schema::dropIfExists('pms_rsm_success_indicators');
    }
}
