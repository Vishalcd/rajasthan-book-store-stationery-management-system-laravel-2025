<x-app-layout>
    <x-slot name="title">{{ __('Withdraw') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Withdraw Amount') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border shadow-sm sm:rounded-lg p-8">

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $school->name }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            Current Revenue:
                            <span class="font-bold text-indigo-600">
                                ₹{{ number_format($school->total_revenue, 2) }}
                            </span>
                        </p>
                    </div>

                    <x-button-back :route="route('schools.show', $school->id)" />
                </div>

                <!-- Withdraw Form -->
                <form action="{{ route('withdraw.store', $school->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Amount -->
                    <div>
                        <x-input-label for="amount" value="Withdraw Amount (₹)" />
                        <x-text-input type="number" step="0.01" min="1" id="amount" name="amount"
                            class="mt-1 block w-full" required placeholder="Enter amount"
                            max="{{ $school->total_revenue }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <!-- Note -->
                    <div>
                        <x-input-label for="note" value="Note (optional)" />
                        <textarea id="note" name="note" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Add a note if needed...">{{ old('note') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('note')" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center gap-4">
                        <x-primary-button>
                            {{ __('Withdraw') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>