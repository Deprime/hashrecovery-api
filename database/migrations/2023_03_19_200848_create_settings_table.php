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
    $enum = [
      'string',
      'integer',
      'boolean',
      'datetime',
    ];
    Schema::create('settings', function (Blueprint $table) use ($enum) {
      $table->smallIncrements('id');
      $table->string('key')->unique();
      $table->text('value')->nullable();
      $table->enum('type', $enum)->default('string');
      $table->text('comment')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('settings');
  }
};
