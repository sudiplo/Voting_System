<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
  //relation between election and wardCandidate
    public function wardCandidate(): HasMany
    {
        return $this->hasMany(wardCandidate::class);
    }

    // relation between election and vote
        public function votes(): HasMany
    {
        return $this->hasMany(vote::class);
    }
}
