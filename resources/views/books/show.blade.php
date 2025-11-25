<x-app-layout>
    <x-slot name="title">{{ $book->title ?? 'Book Details' }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $book->title }}
                        </h3>

                        <x-button-back :route="route('books.index')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-16">
                        <!-- Book Cover -->
                        <div class="flex justify-center mb-6">
                            <img src="{{ Storage::exists($book->cover_image) ? asset($book->cover_image) : asset('book-placeholder.png') }}"
                                alt="{{ $book->title }} Book Cover" class="w-40 h-56 object-cover rounded-md shadow-md">
                        </div>

                        <!-- Book Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-[max-content_max-content] gap-12">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Author</h4>
                                <p class="mt-1 text-gray-900">{{ $book->author ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">ISBN</h4>
                                <p class="mt-1 text-gray-900">{{ $book->isbn ?? '—' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Purchase Price</h4>
                                <p class="mt-1 text-gray-900">{{ formatPrice($book->purchase_price) }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">MRP</h4>
                                <p class="mt-1 text-gray-900">{{ formatPrice($book->selling_price) }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Stock Quantity</h4>
                                <p class="mt-1 text-gray-900">{{ $book->stock_quantity ?? 0 }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase">Publisher</h4>
                                <p class="mt-1 text-gray-900">
                                    @if ($book->publisher)
                                    <a href="{{ route('publishers.show', $book->publisher->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $book->publisher->name }}
                                    </a>
                                    @else
                                    —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Description</h4>
                        <p class="mt-2 text-gray-900 leading-relaxed max-w-3xl">
                            {{ $book->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <x-resource-modify resource="Book" routeEdit="{{ route('books.edit', $book->id) }}"
                        routeDelete="{{ route('books.destroy', $book->id) }}" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>