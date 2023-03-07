<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class BtcPayment extends Model
{
  protected $table = "btc_pay";
  protected $primaryKey = "id";
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'userid',
    'crystalid',
    'date',
    'finish',
    'cost',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'date'   => 'datetime',
    'finish' => 'boolean',
    'cost'   => 'integer',
    'userid' => 'integer',
  ];
}
