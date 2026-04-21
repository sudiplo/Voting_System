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
        // 'party' => 'encrypted',
        // 'goal' => 'encrypted',
        'vote' => 'encrypted',
        // 'photo'=> 'encrypted',
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

    // ---------- Paillier Helpers for string ↔ integer ----------
    private function stringToInt($string)
    {
        $hex = bin2hex($string);
        return gmp_strval(gmp_init($hex, 16));
    }

    private function intToString($int)
    {
        $hex = gmp_strval(gmp_init($int), 16);
        if (strlen($hex) % 2) $hex = '0' . $hex;
        return hex2bin($hex);
    }

    // ---------- Mutators (encrypt on set) ----------
    public function setPartyAttribute($value)
    {
        $paillier = app(Paillier::class);
        $intVal = $this->stringToInt($value);
        $this->attributes['party'] = $paillier->encrypt($intVal);
    }

    public function setGoalAttribute($value)
    {
        $paillier = app(Paillier::class);
        $intVal = $this->stringToInt($value);
        $this->attributes['goal'] = $paillier->encrypt($intVal);
    }

    public function setPhotoAttribute($value)
    {
        $paillier = app(Paillier::class);
        $intVal = $this->stringToInt($value);
        $this->attributes['photo'] = $paillier->encrypt($intVal);
    }

    // ---------- Accessors (decrypt on get) ----------
    public function getPartyAttribute($value)
    {
        if (empty($value)) return '';
        try {
            $paillier = app(Paillier::class);
            $decryptedInt = $paillier->decrypt($value);
            return $this->intToString($decryptedInt);
        } catch (\Exception $e) {
            Log::error("Party decrypt failed: " . $e->getMessage());
            return '';
        }
    }

    public function getGoalAttribute($value)
    {
        if (empty($value)) return '';
        try {
            $paillier = app(Paillier::class);
            $decryptedInt = $paillier->decrypt($value);
            return $this->intToString($decryptedInt);
        } catch (\Exception $e) {
            Log::error("Goal decrypt failed: " . $e->getMessage());
            return '';
        }
    }

    public function getPhotoAttribute($value)
    {
        if (empty($value)) return '';
        try {
            $paillier = app(Paillier::class);
            $decryptedInt = $paillier->decrypt($value);
            return $this->intToString($decryptedInt);
        } catch (\Exception $e) {
            Log::error("Photo decrypt failed: " . $e->getMessage());
            return '';
        }
    }


}
