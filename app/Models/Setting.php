<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Setting extends Model
{
  protected $table = 'settings';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'value',
    'comment',
  ];

  /**
   * Scope Prioroty
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopePriority($query)
  {
    return $query->where('key', 'taskpriority');
  }

  /**
   * Scope cracker_id
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeCrackerId($query)
  {
    return $query->where('key', 'cracker_id');
  }
}
