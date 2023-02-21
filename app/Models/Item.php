<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Item extends Model
{
  protected $table = 'storage_item';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'item_id',
    'item_data',
    'position_id',
    'category_id',
    'creator_id',
    'creator_name',
    'add_date',
  ];
}
