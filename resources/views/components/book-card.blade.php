@props(['book'])

<article
    class="border relative border-gray-200 overflow-hidden  hover:shadow-lg transition-shadow duration-300 rounded-md">
    <span
        class=" px-2 py-0.5 text-center absolute right-3 top-3 text-white font-medium text-sm bg-black bg-opacity-50 rounded-md">{{
        formatPrice($book->selling_price) }}</span>
    <img src="{{ Storage::exists($book->cover_image) 
        ? asset($book->cover_image) 
        : asset('book-placeholder.png') }}" alt="{{ $book->title }} Book Cover" class="w-full h-64 object-cover">
    <div class="px-4 ">
        <h3 class="text-sm font-semibold mb-2 truncate pt-4  text-nowrap">{{ $book->title }}</h3>
        <p class="text-gray-600 mb-4 truncate text-nowrap text-xs">{{ __("by")}} <strong>{{ $book->author }}</strong>
        </p>
    </div>
    <a href="{{ route('books.show', $book->id) }}"
        class="text-indigo-500 border-t border-indigo-100 bg-indigo-50 text-sm w-full flex items-center justify-center text-center py-1.5 hover:underline">View
        Details &rarr;</a>
</article>