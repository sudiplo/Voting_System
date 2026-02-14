<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class otps extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
        'attempts',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];
}
