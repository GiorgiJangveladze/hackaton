<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
  use SoftDeletes;

  protected $table = 'persons';

  protected $fillable = [ 'name', 'occupation', 'image', 'person_type_id', 'person_status_id', 'gender'];

  protected $dates = [ 'deleted_at' ];

  public function letters()
  {
    return $this->belongsToMany('App\Models\Letter', 'persons_to_letters', 'person_id', 'letter_id');
  }

  public function factoids()
  {
    return $this->belongsToMany('App\Models\Factoid', 'factoids_to_persons', 'person_id', 'factoid_id');
  }

  public function factoidRequests()
  {
    return $this->belongsToMany('App\Models\FactoidRequest', 'factoid_requests_to_persons', 'person_id', 'factoid_request_id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function requests()
  {
    return $this->hasMany('App\Models\PersonRequest', 'person_id', 'id');
  }

  public function type(){
    return $this->belongsTo('App\Models\PersonType', 'person_type_id', 'id');
  }

  public function status(){
    return $this->belongsTo('App\Models\PersonStatus', 'person_status_id', 'id');
  }

  public function institutions() {
    return $this->belongsToMany('App\Models\Institution', 'institutions_to_person_lecturer', 'person_id', 'institution_id' );
  }

  public function toJson($options = 0) {
    $this->load('letters');
    $this->load('type');

    return json_encode([
      [ 'name' => $this->name ],
      [ 'occupation' => $this->occupation ],
      [ 'letters' => $this->letters->pluck('name')->implode(', ') ],
      [ 'image' => $this->image ]
    ]);
  }

  /*
  Select all person where Person's Type is isset
  */
  // protected static function boot(){
  //   parent::boot();

  //   static::addGlobalScope('personType', function (Builder $builder){
  //       $builder->where('person_type_id', '!=', null);
  //   });
  // }

}
