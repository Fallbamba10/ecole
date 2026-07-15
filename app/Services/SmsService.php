<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $phone, string $message): bool
    {
        $provider = config('services.sms.provider', 'log');

        return match ($provider) {
            'orange' => $this->sendViaOrange($phone, $message),
            'twilio' => $this->sendViaTwilio($phone, $message),
            default => $this->sendViaLog($phone, $message),
        };
    }

    public function sendBulk(array $recipients, string $message): array
    {
        $results = [];
        foreach ($recipients as $phone) {
            $results[$phone] = $this->send($phone, $message);
        }
        return $results;
    }

    private function sendViaOrange(string $phone, string $message): bool
    {
        $token = config('services.sms.orange_token');
        $sender = config('services.sms.orange_sender', 'SchoolManager');

        if (!$token) {
            Log::warning('SMS Orange: token non configuré');
            return false;
        }

        $phone = $this->formatPhone($phone);

        try {
            $response = Http::withToken($token)
                ->post('https://api.orange.com/smsmessaging/v1/outbound/tel:+' . $sender . '/requests', [
                    'outboundSMSMessageRequest' => [
                        'address' => 'tel:+' . $phone,
                        'senderAddress' => 'tel:+' . $sender,
                        'outboundSMSTextMessage' => [
                            'message' => $message,
                        ],
                    ],
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('SMS Orange error: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaTwilio(string $phone, string $message): bool
    {
        $sid = config('services.sms.twilio_sid');
        $token = config('services.sms.twilio_token');
        $from = config('services.sms.twilio_from');

        if (!$sid || !$token || !$from) {
            Log::warning('SMS Twilio: configuration incomplète');
            return false;
        }

        $phone = $this->formatPhone($phone);

        try {
            $response = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'To' => '+' . $phone,
                    'From' => $from,
                    'Body' => $message,
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('SMS Twilio error: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaLog(string $phone, string $message): bool
    {
        Log::info("SMS [LOG MODE] -> {$phone}: {$message}");
        return true;
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 9 && str_starts_with($phone, '7')) {
            $phone = '221' . $phone;
        }

        return $phone;
    }
}
