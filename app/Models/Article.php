<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function category(): BelongsTo
    {
     return $this->belongsTo(Category::class);
    }
}
