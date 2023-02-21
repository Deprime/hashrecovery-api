<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Payment extends Model
{
  protected $table = 'storage_payment';
  protected $primaryKey = null;
  public $incrementing = false;
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'qiwi_login',
    'qiwi_token',
    'qiwi_private_key',
    'qiwi_nickname',
    'way_payment',
    'status',
  ];
}
