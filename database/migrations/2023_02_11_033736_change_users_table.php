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
    Schema::table('storage_users', function (Blueprint $table) {
      $table->string('login', 64)->nullable()->unique('login')->after('user_name');
      $table->string('email', 64)->nullable()->unique('email')->after('login');
      $table->string('password')->nullable()->after('email');
      $table->rememberToken()->after('password');
      $table->string('reset_token', 80)->nullable()->after('remember_token');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('storage_users', function (Blueprint $table) {
      $table->dropColumn(['login', 'email', 'password', 'reset_token', 'remember_token']);
    });
  }
};
