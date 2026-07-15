<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'sender_id',
        'subject',
        'body',
        'is_broadcast',
    ];

    protected function casts(): array
    {
        return [
            'is_broadcast' => 'boolean',
        ];
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients()
    {
        return $this->hasMany(MessageRecipient::class);
    }

    public function recipientUsers()
    {
        return $this->belongsToMany(User::class, 'message_recipients', 'message_id', 'recipient_id')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
