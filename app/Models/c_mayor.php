<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class c_mayor extends Model
{
    protected $table = 'c_mayors'; // Make sure the table name is correct

    protected $fillable = [
        'citizen_id', 'district_id', 'palika_id', 'post', 'party', 'goal', 'vote'
    ];

    protected $casts = [
        'party' => 'encrypted',
        'goal' => 'encrypted',
        'vote' => 'encrypted',
    ];

    // relation between citizen and c_mayor

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(citizenship::class);
    }

    // relation between c_mayor and election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    // relation between c_mayor and district
    public function district(): BelongsTo
    {
        return $this->belongsTo(district::class);
    }

        // relation between c_mayor and palika
    public function palika(): BelongsTo
    {
        return $this->belongsTo(palika::class);
    }
}
