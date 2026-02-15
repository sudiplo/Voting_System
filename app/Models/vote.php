<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class vote extends Model
{
    //
    protected $fillable = [
        'user_id',
        'candidate_id',
        'election_id',
        'post',
    ];

    protected $casts = [
        // 'user_id' => 'encrypted',
        // 'candidate_id' => 'encrypted',
        // 'election_id' => 'encrypted',
        'post' => 'encrypted',
    ];

    // relation between vote and user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relation between vote and candidate
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(wardCandidate::class, 'candidate_id');
    }

    // relation between vote and election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class, 'election_id');
    }

}
