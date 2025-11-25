<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtraItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'price',
        'quantity',
        'total_price',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-calc total_price on create
        static::creating(function ($item) {
            $item->total_price = $item->price * $item->quantity;
        });

        // Auto-calc total_price on update
        static::updating(function ($item) {
            $item->total_price = $item->price * $item->quantity;
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
