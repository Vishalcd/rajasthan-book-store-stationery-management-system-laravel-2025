<?php

namespace App\Models;

use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory, FiltersTrait;

    protected $fillable = [
        'publisher_id',
        'title',
        'author',
        'isbn',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'cover_image',
        'description',
    ];

    // Relationship: each book belongs to a publisher
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
