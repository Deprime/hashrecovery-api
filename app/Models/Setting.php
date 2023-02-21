<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Setting extends Model
{
  protected $table = 'storage_settings';
  protected $primaryKey = null;
  public $incrementing = false;
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'contact',
    'faq',
    'status',
    'status_buy',
    'profit_buy',
    'profit_refill',
    'taskpriority',
  ];
}
