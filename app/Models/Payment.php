<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'student_id',
        'school_id',
        'amount',
        'type',
        'payment_method',
        'reference',
        'status',
        'due_date',
        'paid_at',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' FCFA';
    }
}
