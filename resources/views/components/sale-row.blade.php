@props(['loop', 'sale'])

<tr class="hover:bg-gray-50 text-sm text-stone-600 border-t last:border-b border-gray-200">
    <td class="px-4 py-3 ">{{ $loop->iteration }}</td>
    <td class="px-4 py-3 font-medium">
        <div class="grid">
            <p>{{$sale->invoice->invoice_number }}</p>
        </div>
    </td>
    <td class="px-4 py-3 text-green-600">{{
        formatPrice($sale->amount)?? '-' }}</td>
    <td class="px-4 py-3">
        <a href="{{ route('bundles.show', $sale->bundle->id) }}" class=" text-indigo-500 underline text-sm">{{
            $sale->bundle->bundle_name
            ?? '-' }}</a>
    </td>
    <td class="px-4 py-3">
        <x-date-container>{{ $sale->created_at }}</x-date-container>
    </td>
    <td class="px-4 py-3 ">
        <div class="flex items-center gap-1 justify-center">
            <x-button-icon :target="true" url="{{ route('sales.print', $sale->invoice->id)  }}">
                <x-tabler-printer class="w-5 h-5" />
            </x-button-icon>
        </div>
    </td>
</tr>