<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  HasMany,
  HasOne,
  BelongsTo,
  BelongsToMany,
};

class Category extends Model
{
  protected $table = 'storage_category';
  protected $primaryKey = 'increment';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  // protected $fillable = [
  //   'category_id',
  //   'category_name',
  //   'sortby',
  //   'hash_type_id',
  // ];

  /**
   * Positions
   */
  public function positions(): HasMany
  {
    return $this->hasMany(Position::class, 'category_id', 'category_id');
  }
}
