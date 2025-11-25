@props(['loop', 'bundle'])

<tr class="hover:bg-gray-50 text-sm text-stone-600">
    <td class="px-4 py-3 border-y text-center">{{ $loop->iteration }}</td>
    <td class=" border-y px-4 py-3">
        <div class="grid grid-cols-[max-content_1fr] gap-2 items-center">
            <img src="{{ Storage::exists($bundle->school->logo) ? asset($bundle->school->logo) : asset('no-image-placeholder.png') }}"
                alt="{{ $bundle->school->name }} Logo" class="h-8 w-8 object-contain rounded-full" />
            <div class="grid">
                <p class=" font-medium">{{ $bundle->school->name }}</p>
                <span class=" text-xs flex items-center gap-1"><strong
                        class=" bg-indigo-100 text-indigo-500 rounded-sm px-1 py-0.5 leading-2">{{
                        $bundle->class_name }}</strong> {{ $bundle->school->email
                    }}</span>
            </div>
        </div>
    </td>

    <td class="px-4 py-3 border-y text-sm font-medium">{{
        $bundle->school_percentage
        }}%</td>

    <td class="px-4 py-3 border-y   text-green-600">{{
        formatPrice($bundle->books->sum('purchase_price')) ?? '-' }}
    </td>

    <td class="px-4 py-3 border-y">{{ $bundle->books_count }} Books</td>

    <td class="px-4 py-3 border-y">
        <div class="w-24 aspect-square overflow-hidden bg-indigo-50">
            <img class=" w-full h-full object-contain" src="{{ asset($bundle->qr_code) }}" alt="qr code">
        </div>
    </td>

    <td class="px-4 py-3 border-y ">
        <div class="flex items-center gap-1 justify-center">
            <x-button-icon url="{{ route('bundles.show', $bundle->id) }}">
                <x-tabler-eye class="w-5 h-5" />
            </x-button-icon>
            <x-button-icon url="{{ route('bundles.print', $bundle->id) }}">
                <x-tabler-printer class="w-5 h-5" />
            </x-button-icon>
        </div>
    </td>
</tr>