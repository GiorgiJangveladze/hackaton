<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Authority extends Model
{
  use SoftDeletes;

  protected $table = 'authorities';

  protected $fillable = [ 'name' ];

  protected $dates = [ 'deleted_at' ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'name' => $this->name ]
    ]);
  }
}
