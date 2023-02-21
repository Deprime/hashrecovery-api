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
        Schema::create('storage_purchases', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('user_id')->nullable();
            $table->text('user_login')->nullable();
            $table->text('user_name')->nullable();
            $table->text('receipt')->nullable();
            $table->integer('item_count')->nullable();
            $table->text('item_price')->nullable();
            $table->text('item_price_one_item')->nullable();
            $table->integer('item_position_id')->nullable();
            $table->text('item_position_name')->nullable();
            $table->text('item_buy')->nullable();
            $table->text('balance_before')->nullable();
            $table->text('balance_after')->nullable();
            $table->timestamp('buy_date')->nullable();
            $table->text('buy_date_unix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_purchases');
    }
};
