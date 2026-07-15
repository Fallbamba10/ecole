<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'student_id',
        'classroom_id',
        'school_id',
        'date',
        'status',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
