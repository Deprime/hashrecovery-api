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
        Schema::create('storage_refill', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('user_id')->nullable();
            $table->text('user_login')->nullable();
            $table->text('user_name')->nullable();
            $table->text('comment')->nullable();
            $table->text('amount')->nullable();
            $table->text('receipt')->nullable();
            $table->text('way_pay')->nullable();
            $table->timestamp('dates')->nullable();
            $table->text('dates_unix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_refill');
    }
};
