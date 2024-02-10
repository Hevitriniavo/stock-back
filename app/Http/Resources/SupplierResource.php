<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'image' => $this->resource->imageUrl(),
            'email' => $this->resource->email,
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'created_at' => $this->formatDateToTimestamp($this->resource->created_at),
            'updated_at' => $this->formatDateToTimestamp($this->resource->updated_at),
        ];
    }
}
