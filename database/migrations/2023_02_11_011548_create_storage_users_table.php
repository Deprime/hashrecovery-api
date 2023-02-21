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
        Schema::create('storage_users', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('user_id')->nullable();
            $table->text('user_login')->nullable();
            $table->text('user_name')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('all_refill')->nullable();
            $table->timestamp('reg_date')->nullable();
            $table->text('lang')->nullable()->default('none');
            $table->text('ref')->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_users');
    }
};
