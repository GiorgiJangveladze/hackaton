<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
  protected $table = 'letters';

  /**
   * Get the persons for the free lesson.
   */
  public function persons()
  {
    return $this->belongsToMany('App\Models\Person', 'persons_to_letters', 'letter_id', 'person_id');
  }
}
