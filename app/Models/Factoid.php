<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factoid extends Model
{
  use SoftDeletes;

  protected $table = 'factoids';

  protected $fillable = [ 'text', 'date', 'image', 'factoid_category_id', ];

  protected $dates = [ 'date', 'deleted_at' ];

  public function type()
  {
    return $this->belongsTo('App\Models\FactoidType', 'factoid_type_id', 'id');
  }

  public function source()
  {
    return $this->belongsTo('App\Models\Source', 'source_id', 'id');
  }

  public function persons()
  {
    return $this->belongsToMany('App\Models\Person', 'factoids_to_persons', 'factoid_id', 'person_id');
  }

  public function places()
  {
    return $this->belongsToMany('App\Models\Place', 'factoids_to_places', 'factoid_id', 'place_id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function requests()
  {
    return $this->hasMany('App\Models\FactoidRequest', 'factoid_id', 'id');
  }

  public function toJson($options = 0) {
    $this->load('type');
    $this->load('source');
    $this->load('persons');
    $this->load('places');

    return json_encode([
      [ 'text' => $this->text ],
      [ 'date' => $this->date ? $this->date->format('Y-m-d') : '-' ],
      [ 'places' => $this->places ? $this->places->pluck('name')->implode(', ') : '-'],
      [ 'type' => $this->type ? $this->type->name : '-'],
      [ 'source' => $this->source ? $this->source->name : '-'],
      [ 'persons' => $this->persons ? $this->persons->pluck('name')->implode(', ') : '-'],
      [ 'image' => $this->image ]
    ]);
  }

  // protected static function boot(){
  //     parent::boot();

  //     static::addGlobalScope('factoid_category', function (Builder $builder) {
  //         $builder->where('factoid_category_id', '=', 1);
  //     });
  // }
  
}
