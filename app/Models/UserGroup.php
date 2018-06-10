<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
  protected $table = 'user_groups';

  protected $fillable = [ 'name' ];

  public function redactors()
  {
    return $this->belongsToMany(User::class, 'redactors_to_groups', 'user_group_id', 'user_id');
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'users_to_groups', 'user_group_id', 'user_id');
  }
}
