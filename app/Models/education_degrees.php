<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class education_degrees extends Model
{
    // relation between education degree and ward candidate
    public function wardCandidates()
    {
        return $this->hasMany(wardCandidate::class,'education_id');
    }
    
}
