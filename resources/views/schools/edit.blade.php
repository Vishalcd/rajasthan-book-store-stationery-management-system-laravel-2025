<x-app-layout>
    <x-slot name='title'>{{ __('Update School') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schools') }}
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
                                        {{ __('Update School') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __("Update school.") }}
                                    </p>
                                </header>

                                <x-button-back :route="route('schools.index')" />
                            </div>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('schools.update', $school->id) }}"
                                enctype="multipart/form-data" class="mt-6 space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="name" :value="__('School Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                            required autofocus autocomplete="name" placeholder="Enter school name"
                                            :value="old('name', $school->name)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name', $school->name)" />
                                    </div>

                                    <div>
                                        <x-input-label for="principal_name" :value="__('Principal Name')" />
                                        <x-text-input id="principal_name" name="principal_name" type="text"
                                            class="mt-1 block w-full" required autocomplete="principal_name"
                                            placeholder="e.g. Jhone doe"
                                            :value="old('principal_name', $school->name)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('principal_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('School Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                            required autocomplete="email" placeholder="school@mail.com"
                                            :value="old('email', $school->email)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone" :value="__('Contact Number')" />
                                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                            required autocomplete="phone" placeholder="+91 xxxxx-xxxxx"
                                            :value="old('phone', $school->phone)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                    </div>

                                    <div>
                                        <x-input-label for="address" :value="__('School Address')" />
                                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                            required autocomplete="address" placeholder="123 Main Street"
                                            :value="old('address', $school->address)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                    </div>

                                    <div>
                                        <x-input-label for="logo" :value="__('Upload School Logo')" />
                                        <x-text-input id="logo" name="logo" type="file" class="mt-1 block w-full"
                                            required autocomplete="logo" placeholder="e.g. 50" :value="old('logo')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                                    </div>

                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Update School') }}</x-primary-button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>