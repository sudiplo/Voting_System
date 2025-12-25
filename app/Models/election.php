<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'title',
        'note',
        'election_date',
    ];

    protected $casts = [
        'note' => 'encrypted',
        'election_date' => 'date',
    ];
}
