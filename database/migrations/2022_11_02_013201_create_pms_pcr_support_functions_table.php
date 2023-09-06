<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsPcrSupportFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_pcr_support_functions', function (Blueprint $table) {
            $table->id();
            $table->string("support_function");
            $table->string("success_indicator");
            $table->json("quality")->nullable();
            $table->json("efficiency")->nullable();
            $table->json("timeliness")->nullable();
            $table->integer("percent");
            $table->string("form_type");
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
        Schema::dropIfExists('pms_pcr_support_functions');
    }
}
