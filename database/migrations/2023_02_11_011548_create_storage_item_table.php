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
        Schema::create('storage_item', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('item_id')->nullable();
            $table->text('item_data')->nullable();
            $table->integer('position_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('creator_id')->nullable();
            $table->text('creator_name')->nullable();
            $table->timestamp('add_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_item');
    }
};
