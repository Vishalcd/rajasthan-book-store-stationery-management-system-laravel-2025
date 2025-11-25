<?php

namespace App\Models;

use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory, FiltersTrait;

    protected $fillable = [
        'name',
        'code',
        'principal_name',
        'email',
        'phone',
        'address',
        'logo',
        'total_revenue',
    ];

    // Relationship
    public function bundles(): HasMany
    {
        return $this->hasMany(Bundle::class);
    }
}
