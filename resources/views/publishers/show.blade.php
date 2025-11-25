<x-app-layout>
    <x-slot name="title">{{ $publisher->name ?? 'Publisher Details' }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publisher Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $publisher->name }}
                        </h3>

                        <x-button-back :route="route('publishers.index')" />
                    </div>

                    {{-- Publisher Info --}}
                    <div class="space-y-4 mb-10">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase">Contact Person</h4>
                            <p class="mt-1 text-gray-900">{{ $publisher->contact_person ?? '—' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase">Email</h4>
                            <a href="mailto:{{ $publisher->email }}"
                                class="mt-1 text-indigo-500 underline">{{$publisher->email}}</a>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase">Phone</h4>
                            <a href="tel:+91{{ $publisher->phone }}" class="mt-1 text-indigo-500 underline">+91
                                {{$publisher->phone}}</a>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase">Address</h4>
                            <address class="mt-1 text-gray-900">{{ $publisher->address ?? '—' }}</address>
                        </div>
                    </div>

                    {{-- BOOK LIST --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Books by {{ $publisher->name }}
                    </h3>

                    <div class="overflow-x-auto rounded-md ">
                        <table class="min-w-full table-auto border border-stone-300 ">
                            <thead class="bg-gray-800 text-stone-200 text-left font-medium text-sm">
                                <tr>
                                    <th class="px-4 py-2 border border-stone-700">#</th>
                                    <th class="px-4 py-2 border border-stone-700">Book Name</th>
                                    <th class="px-4 py-2 border border-stone-700">Purchase Price</th>
                                    <th class="px-4 py-2 border border-stone-700">Selling Price</th>
                                    <th class="px-4 py-2 border border-stone-700">Stock</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($books as $index => $book)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border border-stone-300 text-sm">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-4 py-2 border border-stone-300 text-sm font-medium text-gray-800">
                                        {{ $book->title ?? '—' }}
                                    </td>

                                    <td class="px-4 py-2 border border-stone-300 text-sm text-gray-700">
                                        {{ formatPrice($book->purchase_price) }}
                                    </td>

                                    <td class="px-4 py-2 border border-stone-300 text-sm text-gray-700">
                                        {{ formatPrice($book->selling_price) }}
                                    </td>

                                    <td class="px-4 py-2 border border-stone-300 text-sm text-gray-700">
                                        {{ $book->stock_quantity ?? 0 }}
                                    </td>
                                </tr>
                                @empty
                                <x-no-data>Book</x-no-data>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        <x-resource-modify resource="Publisher"
                            routeEdit="{{ route('publishers.edit', $publisher->id) }}"
                            routeDelete="{{ route('publishers.destroy', $publisher->id) }}" />
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>