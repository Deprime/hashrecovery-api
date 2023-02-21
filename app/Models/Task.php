<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Task extends Model
{
  protected $table = 'tasks';
  protected $primaryKey = 'id';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'userid',
    'username',
    'hashid',
    'taskid',
    'percent',
    'finished',
    'priority',
    'date',
    'found',
    'speed',
    'counthash',
    'copov',
    'description',
    'slovar',
    'descriptionhide',
    'datefinish',
    'paid',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'userid' => 'integer',
    'hashid' => 'integer',
    'taskid' => 'integer',
    'finished' => 'boolean',
    'priority' => 'integer',
    'found' => 'boolean',
    'counthash' => 'integer',
    'copov' => 'boolean',
    'date' => 'datetime',
    'datefinish' => 'datetime',
  ];

  /**
   * User
   */
  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'userid', 'user_id');
  }
}
