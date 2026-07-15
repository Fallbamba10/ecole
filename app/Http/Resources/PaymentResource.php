<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'formatted_amount' => $this->formatted_amount,
            'type' => $this->type,
            'payment_method' => $this->payment_method,
            'reference' => $this->reference,
            'status' => $this->status,
            'due_date' => $this->due_date?->toDateString(),
            'paid_at' => $this->paid_at?->toDateString(),
            'note' => $this->note,
            'student_id' => $this->student_id,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
