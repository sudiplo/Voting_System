<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Paillier;
use Illuminate\Support\Facades\Log;

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
        // 'vote' => 'encrypted',
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

    // relation between ward Candidate and vote
        public function votes(): HasMany
    {
        return $this->hasMany(vote::class);
    }

    // relation between ward Candidate and education degree
    public function education(): BelongsTo
    {
        return $this->belongsTo(education_degrees::class,'education_id');
    }
// Cache for the decrypted value (per instance)
    // private $decryptedVoteCache = null;

    // /**
    //  * Accessor: automatically decrypts the vote when you read $candidate->vote
    //  */
    // public function getVoteAttribute($value)
    // {
    //     // If we already decrypted and cached, return it
    //     if ($this->decryptedVoteCache !== null) {
    //         return $this->decryptedVoteCache;
    //     }

    //     // $value is the raw ciphertext from DB (or null)
    //     if (is_null($value)) {
    //         return $this->decryptedVoteCache = 0;
    //     }

    //     try {
    //         $paillier = app(Paillier::class);
    //         $decrypted = $paillier->decrypt($value);
    //         $this->decryptedVoteCache = (int) $decrypted;
    //         return $this->decryptedVoteCache;
    //     } catch (\Exception $e) {
    //         Log::error("Decryption failed for candidate {$this->id}: " . $e->getMessage());
    //         return $this->decryptedVoteCache = -1;
    //     }
    // }
  // Vote accessor: decrypt on the fly for display
    public function getVoteAttribute($value)
    {
        if (empty($value)) return 0;
        try {
            $paillier = app(Paillier::class);
            return (int) $paillier->decrypt($value);
        } catch (\Exception $e) {
            Log::error("Vote decrypt failed: " . $e->getMessage());
            return -1;
        }
    }
    /**
     * Optional: If you ever need to set the raw ciphertext manually,
     * you can keep the default mutator. This method is not required.
     */
    // public function setVoteAttribute($value)
    // {
    //     $this->attributes['vote'] = $value;
    // }

}
