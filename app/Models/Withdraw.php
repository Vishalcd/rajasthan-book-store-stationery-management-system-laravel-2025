<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'amount',
        'note',
    ];

    // Relationship to School
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
