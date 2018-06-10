<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Glossary extends Model
{
  use SoftDeletes;

  protected $table = 'glossaries';

  protected $fillable = [ 'word', 'definition' ];

  protected $dates = [ 'deleted_at' ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function requests()
  {
    return $this->hasMany('App\Models\GlossaryRequest', 'glossary_id', 'id');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'word' => $this->word ],
      [ 'definition' => $this->definition ]
    ]);
  }
}
