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
        Schema::create('storage_settings', function (Blueprint $table) {
            $table->integer('contact')->nullable();
            $table->text('faq')->nullable();
            $table->text('status')->nullable();
            $table->text('status_buy')->nullable();
            $table->text('profit_buy')->nullable();
            $table->text('profit_refill')->nullable();
            $table->integer('taskpriority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_settings');
    }
};
