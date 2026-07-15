<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'user_id',
        'classroom_id',
        'title',
        'content',
        'target',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
