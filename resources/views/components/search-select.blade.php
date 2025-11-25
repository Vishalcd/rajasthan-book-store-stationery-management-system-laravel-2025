@props([
'options' => [],
'name' => 'item',
'placeholder' => 'Search...',
'selected' => null,
])

@php
$selectedValue = old($name) ?? $selected;
$selectedLabel = $selectedValue && isset($options[$selectedValue])
? $options[$selectedValue]
: '';
@endphp

<div class="mt-1">
    <div class="relative search-select" data-name="{{ $name }}">

        {{-- Search Box --}}
        <input type="text"
            class="search-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="{{ $placeholder }}" value="{{ $selectedLabel }}">

        {{-- Dropdown --}}
        <div
            class="options hidden absolute mt-1 w-full bg-white shadow-md rounded-md max-h-40 overflow-y-auto border border-gray-200 z-50">
            @foreach ($options as $key => $value)
            <div class="option px-3 py-2 cursor-pointer hover:bg-indigo-600 hover:text-white text-sm"
                data-value="{{ $key }}">
                {{ $value }}
            </div>
            @endforeach
        </div>

        {{-- Hidden Input --}}
        <input type="hidden" name="{{ $name }}" class="real-input" value="{{ $selectedValue }}">
    </div>

    @error($name)
    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>