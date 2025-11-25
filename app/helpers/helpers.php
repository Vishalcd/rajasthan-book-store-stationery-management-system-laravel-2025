<?php

use App\Models\Publisher;
use App\Models\School;
use Illuminate\Support\Collection;

/**
 * Format price in Indian Rupees using NumberFormatter.
 *
 * @param float|int $price
 * @param string $currency
 * @return string|bool
 */
if (! function_exists('formatPrice')) {
    function formatPrice($price, $currency = 'INR'): bool|string
    {
        $fmt = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($price, $currency);
    }
}

/**
 * Get list of schools as select dropdown options.
 *
 * Example output:
 * [
 *     1 => "St. Xavier School",
 *     2 => "Modern Public School",
 * ]
 *
 * @return \Illuminate\Support\Collection
 */
if (! function_exists('getSchoolOptions')) {
    function getSchoolOptions(): Collection
    {
        return School::pluck('name', 'id');
    }
}

/**
 * Get list of publishers as select dropdown options.
 *
 * Example output:
 * [
 *     1 => "Rajasthan Book Store",
 *     2 => "National Publishers",
 * ]
 *
 * @return \Illuminate\Support\Collection
 */
if (! function_exists('getPublisherOptions')) {
    function getPublisherOptions(): Collection
    {
        return Publisher::pluck('name', 'id');
    }
}

/**
 * Date filter options for dashboard charts.
 *
 * Used for filtering revenue / sales:
 *
 * @return array<string, string>
 */
function getDateFilterOptions(): array
{
    return [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last_7_days' => 'Last 7 Days',
        'last_30_days' => 'Last 30 Days',
        'this_month' => 'This Month',
    ];
}
