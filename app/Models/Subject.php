<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'name',
        'coefficient',
        'classroom_id',
        'school_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
