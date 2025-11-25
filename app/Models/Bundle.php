<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'bundle_name',
        'class_name',
        'school_percentage',
        'customer_discount',
        'qr_code',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_bundle');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }


    // Generate QR code URL (for frontend use)
    public function getQrUrlAttribute(): string
    {
        return url("/checkout/bundle/{$this->qr_code}");
    }
}
