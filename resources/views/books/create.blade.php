<x-app-layout>
    <x-slot name='title'>{{ __('Add Book') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border sm:rounded-md">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-full">
                        <section>
                            <div class="flex  justify-between">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Add New Book') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __("Add new publisher.") }}
                                    </p>
                                </header>

                                <x-button-back :route="route('books.index')" />
                            </div>

                            <form method="post" action="{{ route('books.store') }}" enctype="multipart/form-data"
                                class="mt-6 space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="title" :value="__('Book Title')" />
                                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                            required autofocus autocomplete="title" placeholder="Book title"
                                            :value="old('title')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                    </div>

                                    <div>
                                        <x-input-label for="author" :value="__('Author Name')" />
                                        <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                                            required autocomplete="author" placeholder="e.g. Jhone doe"
                                            :value="old('author')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('author')" />
                                    </div>

                                    <div class="col-span-full">
                                        <x-input-label for="publisher_id" :value="__('Select Publisher')" />
                                        <x-search-select name="publisher_id" :options="getPublisherOptions()"
                                            placeholder="Search publisher..." :selected="old('publisher_id')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('publisher_id')"
                                            :value="old('publisher_id')" />
                                    </div>

                                    <div>
                                        <x-input-label for="purchase_price" :value="__('Book Purchase Price')" />
                                        <x-text-input id="purchase_price" name="purchase_price" type="number"
                                            class="mt-1 block w-full" required autocomplete="purchase_price"
                                            placeholder="{{ formatPrice(200) }}" :value="old('purchase_price')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('purchase_price')" />
                                    </div>

                                    <div>
                                        <x-input-label for="selling_price" :value="__('Book Selling Price')" />
                                        <x-text-input id="selling_price" name="selling_price" type="number"
                                            class="mt-1 block w-full" required autocomplete="selling_price"
                                            placeholder="{{ formatPrice(250) }}" :value="old('selling_price')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('selling_price')" />
                                    </div>

                                    <div>
                                        <x-input-label for="stock_quantity" :value="__('Book Stock Quantity')" />
                                        <x-text-input id="stock_quantity" name="stock_quantity" type="number"
                                            class="mt-1 block w-full" required autocomplete="stock_quantity"
                                            placeholder="e.g. 50" :value="old('stock_quantity')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('stock_quantity')" />
                                    </div>

                                    <div>
                                        <x-input-label for="cover_image" :value="__('Upload book Cover')" />
                                        <x-text-input id="cover_image" name="cover_image" type="file"
                                            class="mt-1 block w-full" required autocomplete="cover_image"
                                            placeholder="e.g. 50" :value="old('cover_image')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                                    </div>

                                    <div class=" col-span-full">
                                        <x-input-label for="description" :value="__('Book Description')" />
                                        <x-text-input id="description" name="description" type="textarea"
                                            class="mt-1 block w-full" required autocomplete="description"
                                            placeholder="Enter book description" :value="old('description')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                    </div>

                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Add Book') }}</x-primary-button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>