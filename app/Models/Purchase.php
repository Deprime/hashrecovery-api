<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  HasMany,
  HasOne,
  BelongsTo,
  BelongsToMany,
};

use App\Models\User;

class Purchase extends Model
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
    'real_user_id',
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
    return $this->belongsTo(User::class, 'real_user_id', 'increment');
  }

  /**
   * Create payload
   */
  public static function createPayload(User $user, int $price, int $hashlistId): array {
    $balance_before = $user->balance;
    $balance_after  = $user->balance - $price;
    $purchase_date  = strtotime(date("Y-m-d H:i:s"));

    $payload = [
      'real_user_id' => $user->increment,
      'user_id'      => $user->user_id,
      'user_login'   => $user->user_login,
      'user_name'    => $user->user_name,
      'receipt'      => $hashlistId,
      'item_count'   => 1,
      'item_price'   => $price,
      // 'item_price_one_item' => $price,
      // 'item_position_id' => $position->position_id,
      // 'item_position_name' => $position->position_name,
      // 'item_buy' => $position->position_name,
      'balance_before' => $balance_before,
      'balance_after'  => $balance_after,
      'buy_date'       => $purchase_date,
      'buy_date_unix'  => $purchase_date,
    ];
    return $payload;
  }
}
