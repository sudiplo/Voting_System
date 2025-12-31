<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class wardCandidate extends Model
{
    //
    protected $table = 'ward_candidates'; // Make sure the table name is correct

    protected $fillable = [
        'citizen_id', 'district_id', 'palika_id', 'ward_id', 'post', 'party', 'goal', 'vote', 'photo'
    ];

    protected $casts = [
        'party' => 'encrypted',
        'goal' => 'encrypted',
        'vote' => 'encrypted',
        'photo'=> 'encrypted',
    ];

    // relation between ward Candidate and citizen

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(citizenship::class);
    }

    // relation between ward Candidate and election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    // relation between ward Candidate and district
    public function district(): BelongsTo
    {
        return $this->belongsTo(district::class);
    }

    // relation between ward Candidate and palika
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }

    // relation between ward Candidate and ward
    public function ward(): BelongsTo
    {
        return $this->belongsTo(ward::class);
    }
}
