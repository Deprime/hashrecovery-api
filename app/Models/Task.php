<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
  BelongsTo,
};

use App\Models\User;
use App\Models\Position;

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
    'real_user_id',
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
    // 'date' => 'datetime',
    'datefinish' => 'datetime',
  ];

  /**
   * Get priority attribute
   *
   * @param  i  $value
   * @return string
   */
  public function getPriorityAttribute($value)
  {
    $synth = $value - 990000000;
    return $synth < 0 ? 0 : $synth;
  }

  /**
   * User
   */
  public function User(): BelongsTo
  {
    return $this->belongsTo(User::class, 'userid', 'user_id');
  }


  /**
   * Create payload
   */
  public static function createPayload(
    User $user,
    Position $position,
    int $hashlist_id,
    int $task_id,
    int $priority,
    string $hash,
  ): array {
    $payload = [
      'real_user_id' => $user->increment,
      'userid'       => $user->user_id,
      'username'     => $user->user_name,
      'hashid'       => $hashlist_id,
      'taskid'       => $task_id,
      'percent'      => 0,
      'finished'     => "False",
      'priority'     => $priority,
      'date'         => strtotime(date("Y-m-d H:i:s")),
      'found'        => 0,
      'speed'        => 0,
      'counthash'    => 1, # TODO: add hash counter
      'copov'        => 0,
      'description'  => $hash,
      'slovar'       => $position->position_name,
      'descriptionhide' => $position->category->category_name,
      'datefinish'      => null,
      'paid'            => $position->position_price > 0 ? 1 : 0,
    ];
    return $payload;
  }
}
