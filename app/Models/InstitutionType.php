<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InstitutionType extends Model {
    
    protected $table = 'institution_types';

    protected $fillable = [ 'name' ];

    public function institutions(){
        return $this->hasMany('App\Models\Institution');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
