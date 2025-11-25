@props(['type', 'message'])

@if (session()->has($type))
<!-- Alert -->
<div id="alert" class="fixed bottom-0 right-12 translate-y-full  z-50 ">
    <div
        class="p-3 px-12 font-semibold tracking-tight {{$type ===  'success' ? 'text-green-50  bg-green-600' : 'text-red-50 bg-red-600'}} shadow-md transition-all  ml-auto rounded-md flex items-center justify-center gap-2 w-max">
        <span class="flex items-center gap-1.5">
            @if ($type === 'success')
            <x-tabler-circle-check />
            @else
            <x-tabler-circle-x />
            @endif
            {{$message}}
        </span>
    </div>
</div>
@endif