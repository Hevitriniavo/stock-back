<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'movement_date',
        'quantity',
        'movement_type',
        'supplier_id',
    ];


    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }


}
