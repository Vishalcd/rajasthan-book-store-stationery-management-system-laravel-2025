<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="header">
        <div class="flex w-full gap-3 items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 tracking-tight">Dashboard</h2>

            <x-filter-box>
                <div>
                    <x-input-label for="date_filter" value="Filter Revenue" />

                    <x-select id="date_filter" name="date_filter" :options="getDateFilterOptions()"
                        :selected="request('date_filter')" />
                </div>
            </x-filter-box>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Total Books --}}
                <div
                    class="p-5 bg-white border border-gray-200 rounded-xl grid grid-cols-[40px_1fr_1fr] gap-x-4 grid-row-2">
                    <div class="flex items-center justify-between col-span-1 row-start-1 row-end-3">
                        <x-tabler-book class="w-7 h-7 text-green-600" />
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 col-span-2 row-start-1 row-end-2">{{ $totalBooks }}
                    </h2>
                    <p class="text-gray-500 text-sm col-span-2 row-start-2 row-end-3">Total Books</p>
                </div>

                {{-- Total Bundles --}}
                <div
                    class="p-5 bg-white border border-gray-200 rounded-xl grid grid-cols-[40px_1fr_1fr] gap-x-4 grid-row-2">
                    <div class="flex items-center justify-between col-span-1 row-start-1 row-end-3">
                        <x-tabler-packages class="w-7 h-7 text-blue-600" />
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 col-span-2 row-start-1 row-end-2">{{ $totalBundles
                        }}</h2>
                    <p class="text-gray-500 text-sm col-span-2 row-start-2 row-end-3">Total Bundles</p>
                </div>

                {{-- Sold Bundles --}}
                <div
                    class="p-5 bg-white border border-gray-200 rounded-xl grid grid-cols-[40px_1fr_1fr] gap-x-4 grid-row-2">
                    <div class="flex items-center justify-between col-span-1 row-start-1 row-end-3">
                        <x-tabler-shopping-cart class="w-7 h-7 text-indigo-600" />
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 col-span-2 row-start-1 row-end-2">{{ $soldBundles
                        }}</h2>
                    <p class="text-gray-500 text-sm col-span-2 row-start-2 row-end-3">Sold Bundles</p>
                </div>

                {{-- Total Revenue --}}
                <div
                    class="p-5 bg-white border border-gray-200 rounded-xl grid grid-cols-[40px_1fr_1fr] gap-x-4 grid-row-2">
                    <div class="flex items-center justify-between col-span-1 row-start-1 row-end-3">
                        <x-tabler-currency-rupee class="w-7 h-7 text-orange-600" />
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 col-span-2 row-start-1 row-end-2">
                        {{ formatPrice($totalRevenue) }}
                    </h2>
                    <p class="text-gray-500 text-sm col-span-2 row-start-2 row-end-3">Total Revenue</p>
                </div>

            </div>

            {{-- Charts & Recent Sales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Recent Sales --}}
                <div class="bg-white border border-gray-200 rounded-xl">
                    <div class="p-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-700">Recent Sales</h3>
                    </div>

                    <ul class="divide-y">
                        @forelse ($recentSales as $sale)
                        <li class="p-2 px-4 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-sm text-gray-900">
                                    Sale #{{ $sale->id }}
                                </p>

                                <span class="text-xs text-gray-500">
                                    {{ $sale->bundle->bundle_name ?? 'N/A' }} —
                                    {{ formatPrice($sale->invoice->amount ?? 0) }}
                                </span>

                                <p class="text-[11px] text-gray-400">
                                    {{ $sale->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <x-button-icon :target="true" url="{{ route('sales.print', $sale->invoice->id) }}">
                                <x-tabler-printer class="w-5 h-5" />
                            </x-button-icon>
                        </li>
                        @empty
                        <x-no-data>Sales</x-no-data>
                        @endforelse
                    </ul>
                </div>

                {{-- Bundle Distribution --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Bundle Distribution</h3>
                    <div class="p-5 flex h-full justify-center items-center">
                        <canvas id="donutChart" data-labels='@json($bundleLabels)' data-values='@json($bundleCounts)'
                            class="w-full h-full">
                        </canvas>
                    </div>
                </div>

            </div>

            {{-- Revenue Line Chart --}}
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                    Revenue ({{ $selectedFilterLabel }})
                </h3>

                <canvas id="lineChart" data-labels='@json($revenueLabels)' data-values='@json($revenueValues)'
                    class="w-full h-36">
                </canvas>
            </div>

        </div>
    </div>

    {{-- Filter Auto Submit --}}
    <script>
        document.getElementById('date_filter').addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });

        // Format Rupee (JS)
        function rupee(amount) {
            return new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR'
            }).format(amount);
        }
    </script>

</x-app-layout>