<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class winner extends Model
{
    //
     protected $fillable = [
        'election_id',
        'candidate_id',
        'post',
        'palika_id',
        'ward_id',
        'vote_count',
        'is_tie',
    ];
    public function candidate()
{
    return $this->belongsTo(wardCandidate::class, 'candidate_id');
}
}
