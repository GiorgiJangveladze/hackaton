<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
  use SoftDeletes;

  protected $table = 'sources';

  protected $fillable = [
    'name', 'date', 'publish_number', 'publish_place', 'language', 'publisher', 'code', 'comment', 'link',
    'page_count', 'page_number'
  ];

  protected $dates = [ 'date', 'deleted_at' ];

  public function type()
  {
    return $this->belongsTo('App\Models\SourceType', 'source_type_id', 'id');
  }

  public function authority()
  {
    return $this->belongsTo('App\Models\Authority', 'authority_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function requests()
  {
    return $this->hasMany('App\Models\SourceRequest', 'source_id', 'id');
  }
  
  public function factoids()
  {
    return $this->hasMany('App\Models\Factoid', 'source_id', 'id');
  }

  public function toJson($options = 0) {
    $this->load('type');
    $this->load('authority');

    return json_encode([
      [ 'name' => $this->name ],
      [ 'type' => $this->type->name ],
      [ 'date' => $this->date ? $this->date->format('Y-m-d') : '-' ],
      [ 'publish_number' => $this->publish_number ],
      [ 'page_count' => $this->page_count ],
      [ 'page_number' => $this->page_number ],
      [ 'publish_place' => $this->publish_place ],
      [ 'language' => $this->language ],
      [ 'publisher' => $this->publisher ],
      [ 'authority' => $this->authority->name ],
      [ 'code' => $this->code ],
      [ 'comment' => $this->comment ],
      [ 'link' => $this->link ]
    ]);
  }
}
