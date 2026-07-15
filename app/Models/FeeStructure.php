<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeStructure extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'classroom_id',
        'label',
        'type',
        'amount',
        'occurrences',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function getTotalAttribute(): int
    {
        return $this->amount * $this->occurrences;
    }
}
