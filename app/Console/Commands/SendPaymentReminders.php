<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Notifications\PaymentOverdueNotification;
use Illuminate\Console\Command;

class SendPaymentReminders extends Command
{
    protected $signature = 'payments:send-reminders';
    protected $description = 'Envoie des notifications pour les paiements en retard';

    public function handle()
    {
        $overduePayments = Payment::where('status', 'en_attente')
            ->where('due_date', '<', now())
            ->get();

        $updated = 0;

        foreach ($overduePayments as $payment) {
            $payment->update(['status' => 'en_retard']);

            if ($payment->student && $payment->student->school) {
                $admins = $payment->student->school->users()->role('admin_ecole')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new PaymentOverdueNotification($payment));
                }
            }

            $updated++;
        }

        $this->info("{$updated} paiement(s) marqué(s) en retard et notification(s) envoyée(s).");

        return Command::SUCCESS;
    }
}
