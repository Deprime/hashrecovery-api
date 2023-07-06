<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rig extends Model
{
  protected $table = 'rig';
  protected $primaryKey = 'id';
  // public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'agent_id',
    'name',
    'real_name',
    'comment',
  ];

    /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'real_name',
    'agent_id',
    'comment',
    'created_at'
  ];
}
