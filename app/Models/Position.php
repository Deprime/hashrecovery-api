<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  HasMany,
  HasOne,
  BelongsTo,
  BelongsToMany,
};

class Position extends Model
{
  protected $table = 'storage_position';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'position_id',
    'position_name',
    'position_price',
    'position_discription_en',
    'position_discription_ru',
    'position_image',
    'position_date',
    'category_id',
  ];

  /**
   * Category
   */
  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id', 'category_id');
  }
}
