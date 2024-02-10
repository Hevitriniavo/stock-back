<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_date',
        'delivery_address',
    ];


    public function formatDateToTimestamp($dateTimeString): string
    {
        $timestamp = strtotime($dateTimeString);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function deliveryDetails(): HasMany
    {
        return $this->hasMany(DeliveryDetail::class);
    }
}
