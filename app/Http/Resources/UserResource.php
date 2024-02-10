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
            'id' => $this->resource->id,
            'image' => $this->resource->imageUrl(),
            'first_name' => $this->resource->first_name,
            'phone_number' => $this->resource->phone_number,
            'last_name' => $this->resource->last_name,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'user_type' => $this->resource->user_type,
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'role' => $this->resource->role,
            'created_at' => $this->formatDateToTimestamp($this->resource->created_at),
            'updated_at' => $this->formatDateToTimestamp($this->resource->updated_at),
        ];
    }
}
