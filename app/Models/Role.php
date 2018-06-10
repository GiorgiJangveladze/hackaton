<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = [
    'role_description'
  ];

  public function rights()
  {
    return $this->belongsToMany(Right::class, 'role_rights', 'role_id', 'right_id');
  }

  public function users()
  {
    /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation */
    $relation = $this->belongsToMany(User::class, 'user_roles', 'user_id', 'role_id');
    return $relation->withTimestamps();
  }
}
