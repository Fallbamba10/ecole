<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'date' => $this->date?->toDateString(),
            'status' => $this->status,
            'comment' => $this->comment,
            'student_id' => $this->student_id,
            'classroom_id' => $this->classroom_id,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
