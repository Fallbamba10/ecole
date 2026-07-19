<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Illuminate\Notifications\Notification;

class ParentNotifier
{
    public static function notify(Student $student, Notification $notification): void
    {
        $parent = self::findParent($student);

        if ($parent) {
            $parent->notify($notification);
        }
    }

    public static function findParent(Student $student): ?User
    {
        return User::where('school_id', $student->school_id)
            ->role('parent')
            ->where(function ($q) use ($student) {
                if ($student->parent_phone) {
                    $q->where('phone', $student->parent_phone);
                }
                if ($student->parent_email) {
                    $q->orWhere('email', $student->parent_email);
                }
            })
            ->first();
    }
}
