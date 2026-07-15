<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'birth_date' => $this->birth_date?->toDateString(),
            'gender' => $this->gender,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
            'parent_email' => $this->parent_email,
            'address' => $this->address,
            'status' => $this->status,
            'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
