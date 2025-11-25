@props(['initialBooks' => []])

<div id="book-selector" data-search-url="{{ route('books.search') }}" data-initial-books='@json($initialBooks)'
    class="space-y-4">

    {{-- 🔍 Search Bar --}}
    <div class="relative">
        <input type="text" id="book-search" placeholder="Search books by name or author..."
            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
        <div id="loader" class="absolute right-3 top-2.5 hidden">
            <x-tabler-inner-shadow-bottom-left class="animate-spin h-5 w-5 text-indigo-500" />
        </div>
    </div>

    {{-- 🧾 Selected Books --}}
    <div id="selected-books" class="hidden mt-4 bg-gray-50 border border-gray-200 rounded-md p-3">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Selected Books</h3>
        <div id="selected-books-list" class="flex flex-wrap gap-2 text-sm"></div>
    </div>

    {{-- 📚 Books Grid --}}
    <div id="books-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 my-6"></div>

</div>