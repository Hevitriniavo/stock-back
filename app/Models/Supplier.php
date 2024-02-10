<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'email',
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


    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->image);
    }
}
