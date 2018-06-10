<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceType extends Model {
  use SoftDeletes;

  protected $table = 'source_types';

  protected $fillable = [ 'name' ];

  protected $dates = [ 'deleted_at' ];

  public function user() {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function sources(){
    return $this->hasMany('App\Models\Source');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'name' => $this->name ]
    ]);
  }
}
