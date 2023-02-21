<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Category extends Model
{
  protected $table = 'storage_purchases';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'user_login',
    'user_name',
    'receipt',
    'item_count',
    'item_price',
    'item_price_one_item',
    'item_position_id',
    'item_position_name',
    'item_buy',
    'balance_before',
    'balance_after',
    'buy_date',
    'buy_date_unix',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'receipt' => 'integer',
    'item_price' => 'integer',
    'balance_before' => 'integer',
    'balance_after' => 'integer',
    'buy_date' => 'datetime',
    'buy_date_unix' => 'datetime',
  ];

  /**
   * User
   */
  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }
}
