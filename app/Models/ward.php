<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ward extends Model
{
// retation between palka and ward
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }
}
