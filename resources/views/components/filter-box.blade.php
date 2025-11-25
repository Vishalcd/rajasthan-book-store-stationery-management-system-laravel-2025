<div class="relative w-auto">

    {{-- FILTER BUTTON --}}
    <button id="filterBtn" class="inline-flex w-full justify-center gap-1 items-center px-4 py-2 bg-stone-100 border border-stone-200 
        rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest 
        hover:bg-stone-200 focus:bg-stone-200 active:bg-stone-300 
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
        transition duration-150">
        <x-tabler-adjustments-alt width="18" height="18" />
        Filter
    </button>

    {{-- FILTER BOX --}}
    <div id="filterBox" class="hidden absolute mt-2 min-w-96 right-0 bg-white border border-gray-200 
        shadow-xl rounded-lg p-6 z-50">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Filter Options</h3>

            <button id="filterClose" class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none 
                focus:ring-2 focus:ring-indigo-500 rounded">
                <x-tabler-x width="20" />
            </button>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" class="grid grid-cols-1 gap-4">

            {{-- Your passed filters --}}
            {{ $slot }}

            {{-- ACTION BUTTONS --}}
            <div class="col-span-full flex justify-end gap-3 mt-3">

                {{-- Reset — Breeze UI Style --}}
                <a href="{{ url()->current() }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 
                    rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest 
                    shadow-sm hover:bg-gray-50 active:bg-gray-200 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    transition duration-150">
                    Reset
                </a>

                {{-- Apply --}}
                <x-primary-button>{{ __('Apply') }}</x-primary-button>
            </div>

        </form>

    </div>
</div>