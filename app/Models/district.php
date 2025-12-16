<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class district extends Model
{
        // relation between district and palika
    public function palika(): HasMany
    {
        return $this->hasMany(palika::class);
    }
    // relation between district and citizen
    public function citizens(): HasMany
    {
        return $this->hasMany(citizenship::class);
    }
}
