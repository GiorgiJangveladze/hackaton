<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model {
    
    protected $table = 'person_types';

    protected $fillable = [ 'name', 'main_type_id'];


    public function persons(){
        return $this->hasMany('App\Models\Person');
      }

    public function mainType(){
        return $this->belongsTo('App\Models\PersonMainType');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function toJson($options = 0) {
        return json_encode([
          [ 'name' => $this->name ],
        ]);
      }

}
