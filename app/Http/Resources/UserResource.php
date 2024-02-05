<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'image' => $this->imageUrl(),
            'first_name' => $this->first_name,
            'phone_number' => $this->phone_number,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'address' => $this->address,
            'city' => $this->city,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
