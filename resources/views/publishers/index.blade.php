<x-app-layout>
    <x-slot name='title'>{{ __('Publishers') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publishers') }}
        </h2>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-3">
            <x-search search="name" />
            <x-button-link url="{{ route('publishers.create') }}">
                <x-tabler-circle-plus width="18" height="18" /> {{ __('Add New Publisher') }}
            </x-button-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border sm:rounded-md">
                <div class=" text-gray-900">
                    <div class="bg-white overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-800 text-stone-200 text-left font-medium text-sm">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Contact Person</th>
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Added At</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($publishers as $publisher)
                                <x-publisher-row :loop="$loop" :publisher="$publisher" />
                                @empty
                                <x-no-data>Publisher</x-no-data>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $publishers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>