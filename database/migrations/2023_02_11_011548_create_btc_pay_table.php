<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('btc_pay', function (Blueprint $table) {
            $table->integer('id')->nullable()->primary();
            $table->integer('userid')->nullable();
            $table->integer('crystalid')->nullable();
            $table->text('date')->nullable();
            $table->text('finish')->nullable()->default('false');
            $table->text('cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('btc_pay');
    }
};
