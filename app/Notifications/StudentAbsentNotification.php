<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentAbsentNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Student $student,
        private string $date
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Absence de ' . $this->student->full_name)
            ->greeting('Bonjour,')
            ->line($this->student->full_name . ' a été marqué(e) absent(e) le ' . $this->date . '.')
            ->line('Classe : ' . ($this->student->classroom->name ?? ''))
            ->action('Voir les détails', url('/attendances/history/' . $this->student->id))
            ->line('Merci de votre attention.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'absence',
            'message' => $this->student->full_name . ' a été absent(e) le ' . $this->date,
            'student_id' => $this->student->id,
        ];
    }
}
