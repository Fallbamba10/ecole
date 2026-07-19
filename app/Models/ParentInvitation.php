<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentInvitation extends Model
{
    protected $fillable = ['school_id', 'student_id', 'phone', 'email', 'token', 'expires_at', 'used_at'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function isValid(): bool
    {
        return is_null($this->used_at) && $this->expires_at->isFuture();
    }
}
