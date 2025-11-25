<x-app-layout>
    <x-slot name='title'>{{ __('Schools') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schools') }}
        </h2>

        <div class="flex items-center gap-3">
            <x-search search="name" />
            <x-button-link url="{{ route('schools.create') }}">
                <x-tabler-circle-plus width="18" height="18" /> {{ __('Add New School') }}
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
                                    <th class="px-4 py-2  ">#</th>
                                    <th class="px-4 py-2  ">Name</th>
                                    <th class="px-4 py-2  ">Contact</th>
                                    <th class="px-4 py-2  ">Revenue</th>
                                    <th class="px-4 py-2  ">Created At</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schools as $index => $school)
                                <x-school-row :loop="$loop" :school="$school" />
                                @empty
                                <x-no-data>School</x-no-data>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $schools->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>