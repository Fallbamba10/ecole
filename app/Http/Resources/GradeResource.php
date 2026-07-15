<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'period' => $this->period,
            'type' => $this->type,
            'value' => $this->value,
            'max_value' => $this->max_value,
            'comment' => $this->comment,
            'subject' => [
                'id' => $this->subject?->id,
                'name' => $this->subject?->name,
                'coefficient' => $this->subject?->coefficient,
            ],
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
