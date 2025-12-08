@props(['loop', 'school'])

<tr class="hover:bg-gray-50 text-sm text-stone-600">
    <td class="px-4 py-3 border-y">{{ $loop->iteration }}</td>
    <td class=" border-y px-4 py-3">
        <div class="grid grid-cols-[max-content_1fr] gap-2 items-center">
            <img src="{{ $school->logo && Storage::exists($school->logo) 
                        ? asset($school->logo) 
                        : asset('no-image-placeholder.png') }}" alt="{{ $school->name }} School Logo"
                class="h-8 w-8 object-contain rounded-full" />
            <div class="grid">
                <p class=" font-medium">{{ $school->name }}</p>
                <a href="mailto:{{ $school->email }}" class=" text-xs font-medium underline text-indigo-500">{{
                    $school->email
                    }}</a>
            </div>
        </div>
    </td>
    <td class="px-4 py-3 border-y">
        <div class="grid">
            <p>{{ $school->principal_name ?? '-'}}</p>
            <a href="tel:+91{{ $school->phone }}" class="text-xs text-indigo-500 font-medium underline">+91 {{
                $school->phone ?? '-'}}</a>
        </div>
    </td>
    <td class="px-4 py-3 border-y  text-green-600">{{
        formatPrice($school->total_revenue) ??
        '-' }}
    </td>
    <td class="px-4 py-3 border-y font-mono">
        <x-date-container>{{ $school->created_at }}</x-date-container>
    </td>
    <td class="px-4 py-3  border-y  text-center">
        <x-button-icon class="mx-auto" url="{{ route('schools.show', $school->id) }}">
            <x-tabler-eye class="w-5 h-5" />
        </x-button-icon>
    </td>
</tr>