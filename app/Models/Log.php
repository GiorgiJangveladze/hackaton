<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'logs';

  protected $fillable = [ 'type', 'module', 'old', 'new' ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }
}
