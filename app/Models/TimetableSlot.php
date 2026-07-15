<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimetableSlot extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'classroom_id',
        'subject_id',
        'teacher_name',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
