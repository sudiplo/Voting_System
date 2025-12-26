<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
  //relation between election and e_mayor
  /**
   * Get all of the comments for the election
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function mayors(): HasMany
  {
      return $this->hasMany(c_mayor::class);
  }
}
