<?php

namespace App\Notifications;

use App\Models\Grade;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGradeNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Grade $grade
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle note — ' . $this->grade->student->full_name)
            ->greeting('Bonjour,')
            ->line('Une nouvelle note a été saisie pour ' . $this->grade->student->full_name . '.')
            ->line('Matière : ' . $this->grade->subject->name)
            ->line('Note : ' . $this->grade->value . '/' . $this->grade->max_value)
            ->action('Voir les notes', url('/grades'))
            ->line('Bonne continuation !');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_grade',
            'message' => 'Nouvelle note en ' . $this->grade->subject->name . ' : ' . $this->grade->value . '/' . $this->grade->max_value . ' pour ' . $this->grade->student->full_name,
            'grade_id' => $this->grade->id,
        ];
    }
}
