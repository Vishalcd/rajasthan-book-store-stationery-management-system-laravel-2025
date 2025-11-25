@props(['search'])

<form method="GET" action="{{ url()->current() }}"
    class="max-w-md focus-within:focus:border-indigo-500 focus-within:focus:ring-offset-2 focus-within:focus:ring-indigo-500">
    <div class="relative">
        <input type="text" name="{{ $search }}" value="{{ request($search) }}" placeholder="Search…"
            class="w-full rounded-md border-gray-300 focus:outline-none bg-gray-100 h-9 pl-10 placeholder:text-gray-400 text-[15px] font-medium" />

        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <x-tabler-search class="w-5 h-5 text-gray-400" />
        </div>
    </div>
</form>