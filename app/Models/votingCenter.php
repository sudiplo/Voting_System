<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class votingCenter extends Model
{
    //relation between voting center and ward
    public function ward(): BelongsTo
    {
        return $this->belongsTo(ward::class);
    }
}
