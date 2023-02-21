<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
  use HasApiTokens;
  protected $table = 'storage_users';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',    // telegram id
    'user_login', // telegram username
    'user_name',  // telegram first name
    'balance',
    'all_refill',
    'reg_date',
    'lang',
    'ref',
    'login',
    'email',
    'password',
    'avatar',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'reg_date' => 'datetime',
  ];
}
