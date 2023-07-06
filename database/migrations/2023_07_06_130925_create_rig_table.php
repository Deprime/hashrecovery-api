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
    Schema::create('rig', function (Blueprint $table) {
      $table->smallIncrements('id');
      $table->unsignedInteger('agent_id')->unique();
      $table->string('name', 50)->unique();
      $table->string('real_name', 120);
      $table->text('comment')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('rig');
  }
};
