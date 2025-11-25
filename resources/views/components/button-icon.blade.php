@props(['url', 'class' => '', 'target' => false])

<a href="{{ $url }}" @if ($target) target="_blank" @endif class="w-8 aspect-square rounded-md flex items-center justify-center text-indigo-500 
           hover:bg-indigo-100 transition
           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
           {{ $class }}">
    {{ $slot }}
</a>