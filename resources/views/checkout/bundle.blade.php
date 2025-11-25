<x-app-layout>
    <x-slot name='title'>{{ __('Checkout') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout – {{ $bundle->bundle_name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Books --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Included Books</h3>

                <div class="divide-y divide-gray-200">
                    @foreach ($bundle->books as $book)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-20 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                <img src="{{Storage::exists($book->cover_image) ? asset($book->cover_image)  : asset('book-placeholder.png') }}"
                                    class="object-cover w-full h-full">
                            </div>

                            <div>
                                <h5 class="font-semibold">{{ $book->title }}</h5>
                                <p class="text-sm text-gray-500">by {{ $book->author ?? 'Unknown' }}</p>
                            </div>
                        </div>

                        <p class="text-indigo-600 font-medium text-sm">
                            {{ formatPrice($book->selling_price) }}
                        </p>
                    </div>
                    @endforeach
                </div>

            </div>

            {{-- FORM START --}}
            <form method="POST" action="{{ route('checkout.bundle.process', $bundle->id) }}" class="space-y-5 mt-5">
                @csrf

                {{-- CUSTOMER FIELDS --}}
                <div class="bg-white shadow-sm rounded-lg p-6 space-y-5">
                    <h3 class="text-lg font-semibold mb-2">Customer Details</h3>

                    <div>
                        <x-input-label for="customer_name" :value="__('Customer Name')" />
                        <x-text-input id="customer_name" name="customer_name" class="mt-1 block w-full" />
                    </div>

                    <div>
                        <x-input-label for="customer_number" :value="__('Mobile Number')" />
                        <x-text-input id="customer_number" name="customer_number" class="mt-1 block w-full" />
                    </div>

                    {{-- Note --}}
                    <div>
                        <x-input-label for="note" :value="__('Note (Optional)')" />
                        <textarea id="note" name="note" class="mt-1 block w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    {{-- Extra Items --}}
                    <div class=" space-y-5" id="extraItemsContainer"></div>

                    {{-- Add Item Button --}}
                    <div class="text-center mt-6">
                        <button type="button" id="addItemBtn"
                            class="text-indigo-500 underline font-semibold hover:underline">
                            + Add Item
                        </button>
                    </div>
                </div>


                {{-- ORDER SUMMARY (Moved Near Submit Button) --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order Summary</h3>


                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Total Book Price:</span>
                            <span>{{ formatPrice($bundlePrice) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Discount ({{ $bundle->customer_discount }}%):</span>
                            <span>- {{ formatPrice($totalDiscount) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Our Revenue:</span>
                            <span>{{ formatPrice($ourRevenue) }}</span>
                        </div>


                        <div class="my-6 py-3 border-y border-dotted border-stone-200">
                            <div class="flex justify-between font-semibold text-gray-900">
                                <span>Bundle Price:</span>
                                <span data-price="{{ $ourRevenue }}" id="bundlePrice">{{
                                    formatPrice($ourRevenue)}}</span>
                            </div>

                            <div class="flex justify-between mt-3">
                                <span>Other Items:</span>
                                <span id="extraTotal">{{ formatPrice(0) }}</span>
                            </div>
                        </div>


                        <div class="flex justify-between text-lg font-bold text-indigo-700">
                            <span>Final Amount to Pay:</span>
                            <span id="finalPay">{{ formatPrice($ourRevenue) }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 mt-4">
                        <input id="confirm_payment" type="checkbox" name="confirm_payment">
                        <label for="confirm_payment">I confirm that payment is received.</label>
                    </div>

                    <div class="flex justify-end mt-5">
                        <x-primary-button id="finalPayBtn">
                            Pay {{ formatPrice($ourRevenue) }}
                        </x-primary-button>
                    </div>

                </div>

            </form>
            {{-- FORM END --}}

        </div>
    </div>
</x-app-layout>