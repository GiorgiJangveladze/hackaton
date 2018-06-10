<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model {
    
    use SoftDeletes;

    protected $table = 'institutions';

    protected $fillable = [ 'name', 'date', 'type_id', 'place_id', 'comment'];

    protected $dates = [ 'date', 'deleted_at' ];

    public function type() {
        return $this->belongsTo('App\Models\InstitutionType', 'type_id', 'id');
    }

    public function place() {
        return $this->belongsTo('App\Models\Place', 'place_id', 'id');
    }

    public function personsDirector() {
        return $this->belongsToMany('App\Models\Person', 'institutions_to_person_director', 'institution_id', 'person_id');
    }

    public function personsLecturer() {
        return $this->belongsToMany('App\Models\Person', 'institutions_to_person_lecturer', 'institution_id', 'person_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
}
