<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'image',
        'address',
        'city',
    ];

    public function formatDateToTimestamp($dateTimeString): string
    {
        $timestamp = strtotime($dateTimeString);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
