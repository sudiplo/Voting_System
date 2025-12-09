<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class district extends Model
{
    public function palika(): HasMany
    {
        return $this->hasMany(palika::class);
    }
}
