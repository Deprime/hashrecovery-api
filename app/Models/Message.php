<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

class Message extends Model
{
  protected $table = 'msguser';
  protected $primaryKey = 'id';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'userid',
    'text',
    'date',
    'send',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'userid' => 'integer',
    'date' => 'datetime',
    'send' => 'boolean',
  ];

  /**
   * User
   */
  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'userid', 'user_id');
  }
}
