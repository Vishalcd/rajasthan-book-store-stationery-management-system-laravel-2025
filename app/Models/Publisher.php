<?php

namespace App\Models;

use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    use HasFactory, FiltersTrait;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
    ];

    // Relation: one publisher can have many books
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
