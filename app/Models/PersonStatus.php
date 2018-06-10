<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonStatus extends Model {
    
    protected $table = 'person_statuses';

    protected $fillable = [ 'name'];


    public function persons(){
        return $this->hasMany('App\Models\Person');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
