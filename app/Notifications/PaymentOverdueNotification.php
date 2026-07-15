<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentOverdueNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Payment $payment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Paiement en retard — ' . $this->payment->student->full_name)
            ->greeting('Bonjour,')
            ->line('Un paiement est en retard pour ' . $this->payment->student->full_name . '.')
            ->line('Montant : ' . $this->payment->formatted_amount)
            ->line('Échéance : ' . $this->payment->due_date->format('d/m/Y'))
            ->action('Voir les paiements', url('/payments'))
            ->line('Merci de régulariser la situation.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_overdue',
            'message' => 'Paiement en retard de ' . $this->payment->formatted_amount . ' pour ' . $this->payment->student->full_name,
            'payment_id' => $this->payment->id,
        ];
    }
}
