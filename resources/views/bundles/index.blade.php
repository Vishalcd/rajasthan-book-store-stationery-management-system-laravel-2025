<x-app-layout>
    <x-slot name='title'>{{ __('Bundles') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bundles') }}
        </h2>
        <div class="flex gap-3">
            <x-button-link url="{{ route('bundles.create') }}">
                <x-tabler-circle-plus width="18" height="18" /> {{ __('Add New Bundle') }}
            </x-button-link>

            <x-filter-box>
                <div>
                    <x-input-label for="school_id" :value="__('School')" />
                    <x-select id="school_id" name="school_id" :options="getSchoolOptions()" :value="old('school_id')" />
                </div>
            </x-filter-box>
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
                                    <th class="px-4 py-2 text-center  ">#</th>
                                    <th class="px-4 py-2  ">School</th>
                                    <th class="px-4 py-2  ">Percantage</th>
                                    <th class="px-4 py-2  ">Prices</th>
                                    <th class="px-4 py-2  ">Books</th>
                                    <th class="px-4 py-2  ">QR Code</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bundles as $bundle)
                                <x-bundle-row :loop="$loop" :bundle="$bundle" />
                                @empty
                                <x-no-data>Bundle</x-no-data>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $bundles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>