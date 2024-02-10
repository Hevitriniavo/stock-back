<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'order_id',
        'selling_price',
        'quantity',
    ];

    public function formatDateToTimestamp($dateTimeString): string
    {
        $timestamp = strtotime($dateTimeString);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
