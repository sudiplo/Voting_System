<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class citizenship extends Model
{
    //relation between citizen and district
    public function district(): BelongsTo
    {
        return $this->belongsTo(district::class);
    }

    //relation between citizen and palika
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }

    //relation between citizen and ward
    public function ward(): BelongsTo
    {
        return $this->belongsTo(ward::class);
    }

    //relation between citizen and c_mayor
    public function Cmayor(): HasMany
    {
        return $this->hasMany(c_mayor::class);
    }
}
