<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class citizenship extends Model
{
    // protected $table = 'c';
    //  protected $fillable = [
    //     'name_nepali',
    //     'name_english',
    //     'citizenship_number',
    //     'father',
    //     'mother',
    //     'dob',
    //     'gender',
    //     'type',
    //     'district_id',
    //     'palika_id',
    //     'ward_id',
    //     'partner',
    //     'photo',
    // ];

    // protected $casts = [
    //     'name_nepali'        => 'encrypted',
    //     'name_english'       => 'encrypted',
    //     'citizenship_number' => 'encrypted',
    //     'father'             => 'encrypted',
    //     'mother'             => 'encrypted',
    //     'dob'                => 'encrypted:date',
    //     'gender'             => 'encrypted:enum',
    //     'type'               => 'encrypted:enum',
    //     'partner'            => 'encrypted',
    //     'photo'              => 'encrypted',
    // ];
    //relation between citizen and district
    public function district(): BelongsTo
    {
        return $this->belongsTo(district::class);
    }

    //relation between citizen and palika
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }

    //relation between citizen and ward
    public function ward(): BelongsTo
    {
        return $this->belongsTo(ward::class);
    }

    //relation between citizen and c_mayor
    public function Cmayor(): HasMany
    {
        return $this->hasMany(c_mayor::class);
    }

    //relation between citizen and wardCandidate
    public function wardCandidate(): HasMany
    {
        return $this->hasMany(wardCandidate::class);
    }
}
