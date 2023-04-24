<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};
use Carbon\Carbon;

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
    'real_user_id',
    'userid',
    'crystalid',
    'date',
    'finish',
    'cost',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [];

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

  /**
   * Scope active
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeFinished($query)
  {
    return $query->where('finish', 'true');
  }
}
