<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\{
  HasMany,
  HasOne,
  BelongsTo,
  BelongsToMany,
};

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

  /**
   * The attributes that should be appended for serialization.
   *
   * @var array<string>
   */
  protected $appends = [
    'has_password'
  ];


  /**
   * Get has password attribute
   *
   * @return \Illuminate\Database\Eloquent\Casts\Attribute
   */
  protected function hasPassword(): Attribute
  {
    return Attribute::make(
      get: fn ($value, $attributes) => $attributes['password'] ? true : false
    );
  }

  /**
   * Tasks
   */
  public function tasks(): HasMany
  {
    return $this->hasMany(Task::class, 'userid', 'user_id');
  }
}
