<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Refill extends Model
{
  protected $table = 'storage_refill';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'real_user_id',
    'user_id',
    'user_login',
    'user_name',
    'comment',
    'amount',
    'receipt',
    'way_pay',
    'dates',
    'dates_unix',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'user_login',
    'user_name',
    'way_pay',
    'comment',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'amount'  => 'integer',
    'receipt' => 'integer',
    // 'dates' => 'datetime',
    // 'dates_unix' => 'datetime',
  ];

  /**
   * User
   */
  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }
}
