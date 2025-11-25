<x-app-layout>
    <x-slot name="title">
        @if (Auth::user()->role === 'admin')
        {{ $school->name ?? 'School Details' }}
        @else
        My School
        @endif
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (Auth::user()->role === 'admin')
            {{ __('School Details') }}
            @else
            My School
            @endif
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">

                    <!-- Top Header -->
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-semibold text-gray-800">{{ $school->name }}</h3>

                        @if (Auth::user()->role === 'admin')
                        <div class="flex items-center gap-3">
                            <x-button-link url="{{ route('withdraw.create', $school->id) }}">
                                <x-tabler-coin-rupee width="18" height="18" />
                                Make Withdraw
                            </x-button-link>

                            <x-button-back :route="route('schools.index')" />
                        </div>
                        @endif
                    </div>

                    <!-- School Information -->
                    <div class="grid grid-cols-1 md:grid-cols-[160px_1fr] gap-10 mb-10">

                        @if ($school->logo)
                        <div class="flex justify-center">
                            <img src="{{ Storage::exists($school->logo) ? asset($school->logo) : asset('no-image-placeholder.png') }}"
                                alt="{{ $school->name }} Logo"
                                class="w-36 h-36 object-cover rounded-full border shadow">
                        </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">School Code</h4>
                                <p class="mt-1 text-gray-900">{{ $school->code ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Principal Name</h4>
                                <p class="mt-1 text-gray-900">{{ $school->principal_name ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Email</h4>
                                <a href="mailto:{{ $school->email }}" class="mt-1 text-indigo-500 underline">
                                    {{ $school->email ?? '—' }}
                                </a>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Phone</h4>
                                <a href="tel:+91{{ $school->phone }}" class="mt-1 text-indigo-500 underline">
                                    {{ $school->phone ?? '—' }}
                                </a>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Address</h4>
                                <p class="mt-1 text-gray-900">{{ $school->address ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Total Revenue</h4>
                                <p class="mt-1 text-green-600 font-semibold">
                                    {{ formatPrice($school->total_revenue) }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- TABS -->
                    <nav class="flex space-x-8 border-b border-gray-100 mb-6">
                        <button data-tab="bundles"
                            class="tab-btn py-3 border-b-2 font-medium text-sm text-indigo-600 border-indigo-600">
                            Bundles
                        </button>

                        <button data-tab="withdraws"
                            class="tab-btn py-3 border-b-2 font-medium text-sm text-gray-500 border-transparent hover:text-gray-700">
                            Withdraws
                        </button>
                    </nav>

                    <!-- Bundles TAB -->
                    <div id="tab-bundles" class="tab-content block space-y-4">
                        <ul class="grid gap-3">
                            @forelse ($school->bundles as $bundle)
                            <li class="p-5 border border-gray-100 rounded-md hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between">

                                    <div class="space-y-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $bundle->bundle_name }}
                                        </h3>

                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Class:</span> {{ $bundle->class_name }}
                                        </p>

                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Percentage:</span>
                                            {{ $bundle->school_percentage }}%
                                        </p>
                                    </div>

                                    <a href="{{ route('bundles.show', $bundle->id) }}"
                                        class="text-indigo-600 text-sm font-medium hover:underline">
                                        View &rarr;
                                    </a>
                                </div>
                            </li>
                            @empty
                            <x-no-data resource="Bundle" />
                            @endforelse
                        </ul>
                    </div>

                    <!-- Withdraws TAB -->
                    <div id="tab-withdraws" class="tab-content hidden space-y-4">
                        <ul class="grid gap-3">
                            @forelse ($withdraws as $withdraw)
                            <li class="p-4 border border-gray-100 rounded-lg  hover:bg-gray-50 transition">
                                <div class="grid grid-cols-3 md:grid-cols-4 gap-4 items-center">

                                    <div class="font-semibold text-gray-900">
                                        {{ formatPrice($withdraw->amount) }}
                                    </div>

                                    <div class="text-gray-600 text-sm flex items-center gap-1">
                                        <x-tabler-calendar width="14" class="text-gray-400" />
                                        {{ $withdraw->created_at->format('d M Y, h:i A') }}
                                    </div>

                                    <div class="text-gray-600 text-sm truncate">
                                        {{ $withdraw->note ?? 'No note' }}
                                    </div>

                                    <div class="hidden md:flex justify-end">
                                        <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
                                            Withdrawn
                                        </span>
                                    </div>

                                </div>
                            </li>
                            @empty
                            <x-no-data resource="Withdraw" />
                            @endforelse
                        </ul>
                    </div>

                    @if (Auth::user()->role === 'admin')
                    <x-resource-modify resource="School" routeEdit="{{ route('schools.edit', $school->id) }}"
                        routeDelete="{{ route('schools.destroy', $school->id) }}" />
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>