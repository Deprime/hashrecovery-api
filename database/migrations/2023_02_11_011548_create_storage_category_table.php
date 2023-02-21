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
        Schema::create('storage_category', function (Blueprint $table) {
            $table->integer('increment')->nullable()->primary();
            $table->integer('category_id')->nullable();
            $table->text('category_name')->nullable();
            $table->integer('sortby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_category');
    }
};
