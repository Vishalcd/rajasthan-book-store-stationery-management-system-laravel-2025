@props(['loop', 'publisher'])

<tr class="hover:bg-gray-50 text-sm text-stone-600 border-b border-stone-200">
    <td class="px-4 py-3">{{ $loop->iteration }}</td>
    <td class="px-4 py-3 font-medium">
        <div class="grid">
            <p>{{ $publisher->name }}</p>
            <a class=" text-indigo-500 underline" href="mailto:{{ $publisher->email }}">{{ $publisher->email }}</a>
        </div>
    </td>
    <td class="px-4 py-3">
        <div class="grid">
            <p>{{ $publisher->contact_person ?? '-'
                }}</p>
            <a class="underline text-xs text-indigo-500" href="tel:+91{{ $publisher->phone }}">+91 {{ $publisher->phone
                }}</a>
        </div>
    </td>
    <td class="px-4 py-3">
        <x-address-container>
            {{ $publisher->address ?? '-' }}
        </x-address-container>
    </td>
    <td class="px-4 py-3">
        <x-date-container :x-slot="$publisher->created_at" />
    </td>
    <td class="px-4 py-3 text-center">
        <x-button-icon url="{{ route('publishers.show', $publisher->id) }}">
            <x-tabler-eye class="w-5 h-5" />
        </x-button-icon>
    </td>
</tr>