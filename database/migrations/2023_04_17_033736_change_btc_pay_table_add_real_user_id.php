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
    Schema::table('btc_pay', function (Blueprint $table) {
      $table->unsignedInteger('real_user_id')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('btc_pay', function (Blueprint $table) {
      $table->dropColumn(['real_user_id']);
    });
  }
};
