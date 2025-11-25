<x-app-layout>
    <x-slot name='title'>{{ __('Add Publisher') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publishers') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border sm:rounded-md">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-full">
                        <section>
                            <div class="flex items-center justify-between">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Add New Publisher') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __("Add new publisher.") }}
                                    </p>
                                </header>

                                <x-button-back :route="route('publishers.index')" />
                            </div>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('publishers.store') }}" class="mt-6 space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="name" :value="__('Publisher Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                            required autofocus autocomplete="name" placeholder="Enter publisher name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="contact_person" :value="__('Contact Person')" />
                                        <x-text-input id="contact_person" name="contact_person" type="text"
                                            class="mt-1 block w-full" required autocomplete="contact_person"
                                            placeholder="e.g. Jhone doe" />
                                        <x-input-error class="mt-2" :messages="$errors->get('contact_person')" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Publisher Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                            required autocomplete="email" placeholder="publisher@mail.com" />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone" :value="__('Contact Number')" />
                                        <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full"
                                            required autocomplete="phone" placeholder="+91 xxxxx-xxxxx" />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                    </div>

                                    <div class=" col-span-full">
                                        <x-input-label for="address" :value="__('Publisher Address')" />
                                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                            required autocomplete="address" placeholder="123 Main Street" />
                                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                    </div>

                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Add Publisher') }}</x-primary-button>

                                    @if (session('status') === 'success')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">{{
                                        __('Publisher Added Successfully.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>