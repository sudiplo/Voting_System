<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class palika extends Model
{
    // relation between district and palika
    public function district(): BelongsTo
    {
        return $this->belongsTo(district::class);
    }

    // relation between palika and ward
    public function wards(): HasMany
    {
        return $this->hasMany(ward::class);
    }

    // relation between palika and citizen
    public function citizens(): HasMany
    {
        return $this->hasMany(citizenship::class);
    }
}
