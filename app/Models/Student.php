<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'phone',
        'photo',
        'parent_name',
        'parent_phone',
        'parent_email',
        'address',
        'status',
        'classroom_id',
        'school_id',
        'school_year_id',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getTotalPaidAttribute(): int
    {
        return $this->payments()->where('status', 'paye')->sum('amount');
    }
}
