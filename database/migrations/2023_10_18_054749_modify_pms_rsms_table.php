<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pms_rsms', function (Blueprint $table) {
            $table->string("code")->nullable()->change();
            $table->string("title")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_rsms', function (Blueprint $table) {
            $table->string("code");
            $table->string("title");
        });
    }
};
