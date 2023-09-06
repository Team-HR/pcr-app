<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('functional')->nullable();
            $table->integer('level')->nullable();
            $table->string('category')->nullable();
            $table->integer('sg')->nullable();
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
        Schema::dropIfExists('sys_positions');
    }
}
