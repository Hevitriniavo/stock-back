<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'unit_price',
        'quantity_stock',
        'category_id',
    ];


    public function formatDateToTimestamp($dateTimeString): string
    {
        $timestamp = strtotime($dateTimeString);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function category(): BelongsTo
    {
     return $this->belongsTo(Category::class);
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function purchaseLines(): HasMany
    {
        return $this->hasMany(PurchaseLine::class);
    }


    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function deliveryDetails(): HasMany
    {
        return $this->hasMany(DeliveryDetail::class);
    }

    public function imageUrl(): ?string
    {
        if ($this->image !== null){
            return Storage::disk('public')->url($this->image);
        }
        return null;
    }
}
