@props(['disabled' => false, 'type' => 'text', 'rows' => 3])

@if ($type === 'file')
{{-- File Input --}}
<input type="file" @disabled($disabled) {{ $attributes->merge([
'class' =>
'block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer bg-gray-50
focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 shadow-sm
file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 py-0.5 px-1',
]) }}
accept="image/*" >

@elseif ($type === 'textarea')
{{-- Textarea --}}
<textarea rows="{{ $rows }}" @disabled($disabled) {{ $attributes->merge([
            'class' =>
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-gray-900',
        ]) }}></textarea>
@else

{{-- Default Input --}}
<input type="{{ $type }}" @disabled($disabled) {{ $attributes->merge([
'class' =>
'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-gray-900',
]) }}
>
@endif