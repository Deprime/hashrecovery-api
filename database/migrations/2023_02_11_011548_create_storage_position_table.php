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
        Schema::create('storage_position', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('position_id')->nullable();
            $table->text('position_name')->nullable();
            $table->integer('position_price')->nullable();
            $table->text('position_discription_en')->nullable();
            $table->text('position_image')->nullable();
            $table->timestamp('position_date')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('position_discription_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_position');
    }
};
