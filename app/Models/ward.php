<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ward extends Model
{
// retation between palka and ward
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }

    // relation between ward and citizen
    public function citizens(): HasMany
    {
        return $this->hasMany(citizenship::class);
    }

    // relation between ward and voting center
    public function votingCenters(): HasMany
    {
        return $this->hasMany(votingCenter::class);
    }

    //relation between ward and wardCandidate
    public function wardCandidate(): HasMany
    {
        return $this->hasMany(wardCandidate::class);
    }
}
