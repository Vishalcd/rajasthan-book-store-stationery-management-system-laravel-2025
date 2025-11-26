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
                <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">

                    <h3 class="text-xl font-bold mb-6 text-gray-800 border-b pb-3 flex items-center gap-2">
                        <x-tabler-receipt-rupee class=" text-gray-800 w-6 h-6" /> Order Summary (Bill)
                    </h3>

                    <!-- BILL BODY -->
                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Book Price:</span>
                            <span class="font-medium">{{ formatPrice($bundlePrice) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Discount ({{ $bundle->customer_discount }}%):</span>
                            <span class="font-medium text-red-600">- {{ formatPrice($totalDiscount) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Our Revenue:</span>
                            <span class="font-medium text-gray-800">{{ formatPrice($ourRevenue) }}</span>
                        </div>

                        <!-- Dotted separator -->
                        <div class="border-t border-dashed my-4"></div>

                        <div class="flex justify-between font-semibold text-gray-900">
                            <span>Bundle Price:</span>
                            <span id="bundlePrice" data-price="{{ $ourRevenue }}">
                                {{ formatPrice($ourRevenue) }}
                            </span>
                        </div>

                        <div class="flex justify-between mt-1">
                            <span class="text-gray-600">Other Items:</span>
                            <span id="extraTotal" class="font-medium">{{ formatPrice(0) }}</span>
                        </div>

                        <!-- Dotted separator -->
                        <div class="border-t border-dashed my-4"></div>

                        <div class="flex justify-between text-lg font-bold text-indigo-700">
                            <span>Total Amount to Pay:</span>
                            <span id="finalPay">{{ formatPrice($ourRevenue) }}</span>
                        </div>

                    </div>

                    <!-- PAYMENT TYPE -->
                    <div class="mt-6 p-4 rounded-lg bg-gray-50 border">
                        <h3 class="text-md font-semibold mb-3 flex items-center gap-2">
                            <x-tabler-credit-card-pay class=" text-gray-800 w-5 h-5" /> Select Payment Type
                        </h3>

                        <div class="flex items-center gap-6">

                            <label class="flex items-center gap-2 cursor-pointer text-gray-700">
                                <input type="radio" required name="payment_type" value="cash"
                                    class="text-indigo-600 h-4 w-4" checked>
                                <span>Cash Payment</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer text-gray-700">
                                <input type="radio" required name="payment_type" value="online"
                                    class="text-indigo-600 h-4 w-4">
                                <span>Online Payment</span>
                            </label>

                        </div>
                    </div>

                    <!-- CONFIRM CHECKBOX -->
                    <div class="flex items-center gap-3 mt-5">
                        <input id="confirm_payment" type="checkbox" required name="confirm_payment"
                            class="h-4 w-4 text-indigo-600 border-gray-300">
                        <label for="confirm_payment" class="text-gray-700">
                            I confirm that payment is received.
                        </label>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex justify-end mt-6">
                        <x-primary-button id="finalPayBtn" class="px-6 py-3 text-base">
                            Pay {{ formatPrice($ourRevenue) }}
                        </x-primary-button>
                    </div>

                </div>

            </form>
            {{-- FORM END --}}

        </div>
    </div>
</x-app-layout>