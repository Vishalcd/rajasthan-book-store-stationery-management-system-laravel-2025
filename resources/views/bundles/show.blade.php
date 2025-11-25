<x-app-layout>
    <x-slot name="title">{{ 'Bundle - ' . ($bundle->class_name ?? 'Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bundle Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $bundle->bundle_name ?? 'Bundle Details' }}
                        </h3>

                        <x-button-back route="{{ route('bundles.index') }}" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-16">
                        <!-- QR Code -->
                        @if ($bundle->qr_code)
                        <div class="flex flex-col items-center mb-6">
                            <img src="{{ asset($bundle->qr_code) }}" alt="{{ $bundle->bundle_name }} QR Code"
                                class="w-40 h-40 object-cover border border-gray-200 rounded-md shadow-md">
                            <a href="{{ route('checkout.bundle.show', $bundle->id) }}" target="_blank"
                                class="mt-3 text-blue-600 text-sm hover:underline break-all">
                                View Checkout Page
                            </a>
                        </div>
                        @endif

                        <!-- Bundle Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-[max-content_max-content] gap-12">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">School</h4>
                                <p class="mt-1 text-gray-900">
                                    <a href="{{ route('schools.show', $bundle->school->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $bundle->school->name }}
                                    </a>
                                </p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Class Name</h4>
                                <p class="mt-1 text-gray-900">{{ $bundle->class_name ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">School Percentage</h4>
                                <p class="mt-1 text-gray-900">{{ $bundle->school_percentage }}%</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Customer Discount</h4>
                                <p class="mt-1 text-gray-900">{{ $bundle->customer_discount }}%</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Bundle Price</h4>
                                <p class="mt-1 text-gray-900">{{ formatPrice($bundle->books->sum('selling_price')) }}
                                </p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Sold Status</h4>
                                <p class="mt-1">
                                    @if ($bundle->is_sold)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Sold</span>
                                    @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Available</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Books -->
                    <div class="mt-10">
                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-3">Books in this Bundle</h4>
                        @if ($bundle->books->count())
                        <ul class=" border border-gray-100 rounded-md">
                            @foreach ($bundle->books as $book)
                            <li
                                class="flex items-center justify-between border-b last:border-b-0 border-gray-100 px-4 py-3 hover:bg-gray-50 transition">
                                <div>
                                    <p class="text-gray-800 font-medium">{{ $book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $book->author ?? '' }}</p>
                                </div>
                                <a href="{{ route('books.show', $book->id) }}"
                                    class="text-blue-600 text-sm hover:underline">View</a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-gray-500">No books added to this bundle.</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <x-resource-modify resource="Bundle" routeEdit="{{ route('bundles.edit', $bundle->id) }}"
                        routeDelete="{{ route('bundles.destroy', $bundle->id) }}" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>