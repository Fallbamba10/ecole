<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'name',
        'level',
        'section',
        'capacity',
        'school_id',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class);
    }
}
