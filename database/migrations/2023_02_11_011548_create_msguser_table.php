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
        Schema::create('msguser', function (Blueprint $table) {
            $table->integer('id')->nullable()->primary();
            $table->text('userid')->nullable();
            $table->text('text')->nullable();
            $table->text('date')->nullable();
            $table->text('send')->nullable()->default('False');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msguser');
    }
};
