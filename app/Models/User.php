<?php
namespace App\Models;
use App\Models\Traits\ManagesUserRightsAndRolesTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use ManagesUserRightsAndRolesTrait;

  protected $fillable = [
    'name', 'email', 'password',
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  protected $with = [
    'rights', 'roles'
  ];

  public function rights()
  {
    /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation */
    $relation = $this->belongsToMany(Right::class, 'user_rights', 'user_id', 'right_id');
    return $relation->withTimestamps();
  }

  public function roles()
  {
    /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation */
    $relation = $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    return $relation->withTimestamps();
  }

  public function groups()
  {
    return $this->belongsToMany(UserGroup::class, 'redactors_to_groups', 'user_id', 'user_group_id');
  }

  public function persons(){
    return $this->hasMany('App\Models\Person', 'user_id', 'id');
  }

  public function institutions(){
    return $this->hasMany('App\Models\Institution', 'user_id', 'id');
  }

  public function sources(){
    return $this->hasMany('App\Models\Source', 'user_id', 'id');
  }

  public function factoids(){
    return $this->hasMany('App\Models\Factoid', 'user_id', 'id');
  }

  public function places(){
    return $this->hasMany('App\Models\Place', 'user_id', 'id');
  }

  public function glossaries(){
    return $this->hasMany('App\Models\Glossary', 'user_id', 'id');
  }


}