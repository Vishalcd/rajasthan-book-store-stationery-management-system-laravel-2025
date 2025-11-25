<x-app-layout>
    <x-slot name='title'>{{ __('Add Bundle') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bundles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border sm:rounded-md">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-full">
                        <section>
                            <div class="flex justify-between">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Add New Bundle') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __("Add new bundle.") }}
                                    </p>
                                </header>

                                <x-button-back route="{{ route('bundles.index') }}" />
                            </div>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('bundles.store') }}" class="mt-6 space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="school_id" :value="__('Select School')" />
                                        <x-search-select name="school_id" :options="getSchoolOptions()"
                                            placeholder="Search school..." :selected="old('school_id')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('school_id')"
                                            :value="old('school_id')" />
                                    </div>

                                    <div>
                                        <x-input-label for="class_name" :value="__('Class Name')" />
                                        <x-text-input id="class_name" name="class_name" type="text"
                                            class="mt-1 block w-full" required autocomplete="class_name"
                                            placeholder="e.g. Class 5th" :value="old('class_name')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('class_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="school_percentage"
                                            :value="__('Bundle School Percentage')" />
                                        <x-text-input id="school_percentage" name="school_percentage" type="number"
                                            class="mt-1 block w-full" required autocomplete="school_percentage"
                                            placeholder="e.g. 30%" :value="old('school_percentage')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('school_percentage')" />
                                    </div>

                                    <div>
                                        <x-input-label for="customer_discount"
                                            :value="__('Customer Discount Percentage')" />
                                        <x-text-input id="customer_discount" name="customer_discount" type="number"
                                            class="mt-1 block w-full" required autocomplete="customer_discount"
                                            placeholder="e.g. 30%" :value="old('customer_discount')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('customer_discount')" />
                                    </div>


                                    <div class="col-span-full">
                                        <x-input-label for="books" :value="__('Select Books For Bundle')" />
                                        <div class=" mt-1 p-6 border border-gray-200 rounded-md">
                                            <x-book-selector :initialBooks="$initialBooks" />
                                            <x-input-error class="mt-2" :messages="$errors->get('books')" />
                                        </div>
                                    </div>

                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Add Bundle') }}</x-primary-button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>