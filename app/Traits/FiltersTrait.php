<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait FiltersTrait
{
    /**
     * Apply filters from request automatically.
     */
    public function scopeFilter(Builder $query, Request $request, array $allowedFilters = []): Builder
    {
        foreach ($allowedFilters as $field => $type) {

            $value = $request->input($field);

            if ($value === null || $value === '') {
                continue;
            }

            // STRING FILTER
            if ($type === 'string') {
                $query->where($field, 'LIKE', "%{$value}%");
            }

            // EXACT MATCH
            elseif ($type === 'exact') {
                $query->where($field, $value);
            }

            // DATE MATCH
            elseif ($type === 'date') {
                $query->whereDate($field, $value);
            }

            // RANGE FILTER
            elseif ($type === 'range') {
                if (isset($value['from'])) {
                    $query->where($field, '>=', $value['from']);
                }
                if (isset($value['to'])) {
                    $query->where($field, '<=', $value['to']);
                }
            }

            // BOOLEAN FILTER
            elseif ($type === 'boolean') {
                $query->where($field, (bool) $value);
            }
        }

        return $query;
    }
}
