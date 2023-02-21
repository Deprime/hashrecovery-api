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
        Schema::create('storage_payment', function (Blueprint $table) {
            $table->text('qiwi_login')->nullable();
            $table->text('qiwi_token')->nullable();
            $table->text('qiwi_private_key')->nullable();
            $table->text('qiwi_nickname')->nullable();
            $table->text('way_payment')->nullable();
            $table->text('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_payment');
    }
};
