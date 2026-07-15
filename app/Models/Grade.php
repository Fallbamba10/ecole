<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'student_id',
        'subject_id',
        'school_id',
        'period',
        'type',
        'value',
        'max_value',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'max_value' => 'decimal:2',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
