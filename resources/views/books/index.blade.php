<x-app-layout>
    <x-slot name='title'>{{ __('Books') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Total') }} {{ $books->total() }} {{ __('Books') }}
        </h2>

        <div class="sm:flex gap-3 grid grid-cols-2">
            <div class=" col-span-full">
                <x-search search="title" />
            </div>
            <x-button-link url="{{ route('books.create') }}">
                <x-tabler-circle-plus width="18" height="18" /> {{ __('Add New Book') }}
            </x-button-link>

            <x-filter-box>
                <div>
                    <x-input-label for="publisher_id" :value="__('Publisher')" />
                    <x-select id="publisher_id" name="publisher_id" :options="getPublisherOptions()"
                        :selected="request('publisher_id')" />
                </div>
            </x-filter-box>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-md  border">
                <div class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-8 p-12">
                    @forelse ($books as $book)
                    <x-book-card :book="$book" />
                    @empty
                    <div class="col-span-full">
                        <x-no-data>Books</x-no-data>
                    </div>
                    @endforelse
                </div>

                <div class="border-t">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>