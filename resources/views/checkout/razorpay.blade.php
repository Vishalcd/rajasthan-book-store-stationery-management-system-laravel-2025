<x-app-layout>

    <x-slot name="title">
        Online Payment – {{ $bundle->bundle_name }}
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-8 border border-gray-100">

                {{-- Title --}}
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    Complete Online Payment
                </h2>

                {{-- Summary Box --}}
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                    <h3 class="text-lg font-medium mb-3 text-gray-800">Order Summary</h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bundle:</span>
                            <span class="font-medium">{{ $bundle->bundle_name }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Customer Name:</span>
                            <span class="font-medium">{{ $customer_name ?: 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Mobile:</span>
                            <span class="font-medium">{{ $customer_number ?: 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between pt-2 mt-2 border-t border-dashed">
                            <span class="font-semibold text-gray-900">Amount to Pay:</span>
                            <span class="text-indigo-600 font-bold text-lg">{{ formatPrice($amount) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Razorpay Button --}}
                <div class="text-center mt-8">

                    <x-primary-button id="payBtn" class="px-6 py-3 text-base">
                        Pay {{ formatPrice($amount) }}
                    </x-primary-button>

                </div>

            </div>
        </div>
    </div>


    {{-- Razorpay Script --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.getElementById('payBtn').onclick = function(e) {
        e.preventDefault();

        let options = {
            "key": '{{ env('RAZORPAY_KEY') }}',
            "amount": "{{ $order['amount'] }}",
            "currency": "INR",
            "name": "Bundle Purchase",
            "description": "Order #{{ $order['id'] }}",
            "order_id": "{{ $order['id'] }}",

            "handler": function (response) {
            window.location.href =
            "{{ route('checkout.bundle.verify') }}"
            + "?razorpay_payment_id=" + response.razorpay_payment_id
            + "&razorpay_order_id=" + response.razorpay_order_id
            + "&razorpay_signature=" + response.razorpay_signature;
            },

            "theme": {
                "color": "#4f46e5"
            }
        };

        let rzp = new Razorpay(options);
        rzp.open();
    };
    </script>

</x-app-layout>