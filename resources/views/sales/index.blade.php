<x-app-layout>
    <x-slot name='title'>{{ __('Sales') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border sm:rounded-md">
                <div class=" text-gray-900">
                    <div class="bg-white overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-800 text-stone-200 text-left font-medium text-sm">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Invoice</th>
                                    <th class="px-4 py-2">Amount Paid</th>
                                    <th class="px-4 py-2">Bundle</th>
                                    <th class="px-4 py-2">Paid at</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                <x-sale-row :loop="$loop" :sale="$sale" />
                                @empty
                                <x-no-data>Sales</x-no-data>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>