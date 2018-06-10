<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
  use SoftDeletes;

  protected $table = 'places';

  protected $fillable = [ 'name', 'description', 'lat', 'lng', 'zoom', 'note' ];

  protected $dates = [ 'deleted_at' ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function requests()
  {
    return $this->hasMany('App\Models\PlaceRequest', 'place_id', 'id');
  }

  public function factoids()
  {
    return $this->belongsToMany('App\Models\Factoid', 'factoids_to_places', 'place_id', 'factoid_id');
  }

  public function institutions()
  {
    return $this->hasMany('App\Models\Institution');
  }

  public function toJson($options = 0) {
    return json_encode([
      [ 'name' => $this->name ],
      [ 'description' => $this->description ],
      [ 'note' => $this->note ],
      [ 'map' => [
          'lat' => $this->lat,
          'lng' => $this->lng,
          'zoom' => $this->zoom
        ]
      ]
    ]);
  }
}
