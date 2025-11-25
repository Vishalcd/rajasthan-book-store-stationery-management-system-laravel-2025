<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bundle;
use App\Models\Invoice;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // ----------------------------
        // DATE FILTER (same as yours)
        // ----------------------------
        $dateFilter = $request->input('date_filter', 'last_30_days');

        switch ($dateFilter) {
            case 'today':
                $chartStart = Carbon::today();
                $selectedFilterLabel = "Today";
                break;

            case 'yesterday':
                $chartStart = Carbon::yesterday();
                $selectedFilterLabel = "Yesterday";
                break;

            case 'last_7_days':
                $chartStart = Carbon::now()->subDays(6)->startOfDay();
                $selectedFilterLabel = "Last 7 Days";
                break;

            case 'this_month':
                $chartStart = Carbon::now()->startOfMonth();
                $selectedFilterLabel = "This Month";
                break;

            case 'custom_date':
                $chartStart = Carbon::parse($request->date_from)->startOfDay();
                $from = Carbon::parse($request->date_from)->format('d M Y');
                $to = Carbon::parse($request->date_to)->format('d M Y');
                $selectedFilterLabel = "$from → $to";
                break;

            default:
                $chartStart = Carbon::now()->subDays(29)->startOfDay();
                $selectedFilterLabel = "Last 30 Days";
        }

        $endDate = Carbon::now()->endOfDay();

        // ----------------------------------------------------
        // 2. BASIC STATS (UPDATED)
        // ----------------------------------------------------
        $totalBooks = Book::count();
        $totalBundles = Bundle::count();

        // sales count according to date
        $soldBundles = Sale::whereBetween('created_at', [$chartStart, $endDate])->count();

        // revenue according to date
        $totalRevenue = Invoice::whereBetween('created_at', [$chartStart, $endDate])
            ->sum('amount');

        // ----------------------------------------------------
        // 3. RECENT SALES (Filtered)
        // ----------------------------------------------------
        $recentSales = Sale::with(['bundle', 'invoice'])
            ->whereBetween('created_at', [$chartStart, $endDate])
            ->latest()
            ->take(7)
            ->get();

        // ----------------------------------------------------
        // 4. TOP BUNDLES (FILTERED BY DATE) — UPDATED
        // ----------------------------------------------------
        $topBundles = Bundle::withCount([
            'sales' => function ($q) use ($chartStart, $endDate) {
                $q->whereBetween('created_at', [$chartStart, $endDate]);
            }
        ])
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        $bundleLabels = $topBundles->pluck('bundle_name')->toArray();
        $bundleCounts = $topBundles->pluck('sales_count')->toArray();

        // ----------------------------------------------------
        // 5. REVENUE CHART (same as yours)
        // ----------------------------------------------------
        $revenueRaw = Invoice::selectRaw("
                DATE(created_at) AS date,
                SUM(amount) AS total
            ")
            ->whereBetween('created_at', [$chartStart, $endDate])
            ->groupByRaw("DATE(created_at)")
            ->orderBy('date')
            ->get();

        $periodDays = $chartStart->diffInDays($endDate) + 1;

        $revenueLabels = [];
        $revenueValues = [];

        for ($i = 0; $i < $periodDays; $i++) {
            $currentDate = $chartStart->copy()->addDays($i);
            $revenueLabels[] = $currentDate->format('M d');

            $record = $revenueRaw->firstWhere('date', $currentDate->toDateString());
            $revenueValues[] = $record ? (float) $record->total : 0;
        }

        return view('dashboard', [
            'totalBooks' => $totalBooks,
            'totalBundles' => $totalBundles,
            'soldBundles' => $soldBundles,
            'totalRevenue' => $totalRevenue,
            'recentSales' => $recentSales,
            'bundleLabels' => $bundleLabels,
            'bundleCounts' => $bundleCounts,
            'revenueLabels' => $revenueLabels,
            'revenueValues' => $revenueValues,
            'selectedFilterLabel' => $selectedFilterLabel,
        ]);
    }
}
