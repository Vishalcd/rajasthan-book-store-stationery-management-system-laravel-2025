@props(['routeEdit', 'routeDelete', 'resource' => ''])

<div class="mt-8 flex justify-end space-x-3">
    <x-button-link url="{{ $routeEdit }}">
        Edit
    </x-button-link>

    <!-- Delete Button -->
    <x-danger-button x-data x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-publisher')">
        <x-tabler-trash class="w-4 h-4" />
    </x-danger-button>
</div>

<!-- Breeze Style Modal -->
<x-modal name="confirm-delete-publisher" focusable>
    <form method="POST" action="{{ $routeDelete }}" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to delete this $resource?") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('This action cannot be undone.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Yes, Delete') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>