@props([
'disabled' => false,
'options' => [],
'selected' => null,
'placeholder' => 'Select an option',
])

<select @disabled($disabled) {{ $attributes->merge([
    'class' =>
    'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
    rounded-md shadow-sm w-full text-gray-900 bg-white cursor-pointer mt-1',
    ]) }}
    >
    @if ($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $label)
    <option value="{{ $value }}" @selected((string)$selected===(string)$value)>
        {{ $label }}
    </option>
    @endforeach
</select>