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
        Schema::create('tasks', function (Blueprint $table) {
            $table->integer('id')->nullable()->primary();
            $table->text('userid')->nullable();
            $table->text('username')->nullable();
            $table->text('hashid')->nullable();
            $table->text('taskid')->nullable();
            $table->text('percent')->nullable()->default('0');
            $table->text('finished')->nullable();
            $table->text('priority')->nullable()->default('0');
            $table->text('date')->nullable();
            $table->text('found')->nullable()->default('0');
            $table->text('speed')->nullable()->default('0');
            $table->text('counthash')->nullable()->default('0');
            $table->text('copov')->nullable()->default('0');
            $table->text('description')->nullable();
            $table->text('slovar')->nullable();
            $table->text('descriptionhide')->nullable();
            $table->text('datefinish')->nullable();
            $table->integer('paid')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
