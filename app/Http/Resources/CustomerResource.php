<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'image' => $this->resource->imageUrl(),
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'created_at' => $this->formatDateToTimestamp($this->resource->created_at),
            'updated_at' => $this->formatDateToTimestamp($this->resource->updated_at),
        ];
    }
}
