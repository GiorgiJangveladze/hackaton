<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonMainType extends Model{
    
    protected $table = 'person_main_types';

    protected $fillable = ['name'];


    public function type(){
        return $this->hasMany('App\Models\PersonType');
      }
    

}
