<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
  //relation between election and e_mayor
  public function mayors(): HasMany
  {
      return $this->hasMany(c_mayor::class);
  }

  //relation between election and wardCandidate
    public function wardCandidate(): HasMany
    {
        return $this->hasMany(wardCandidate::class);
    }
}
