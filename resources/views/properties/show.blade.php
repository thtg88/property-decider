<x-app-layout>
    <x-slot name="header">
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <x-title>{{ $model->title ?? $model->url }}</x-title>
            </div>
        </div>
        <div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
            <form action="{{ route('properties.destroy', $model) }}" method="post">
                @csrf
                @method('delete')
                <x-buttons.danger-button type="submit" data-confirm="Are you sure you want to remove this app?">
                    Remove Property
                </x-buttons.danger-button>
            </form>
        </div>
    </x-slot>

    <x-card>
        Status: {{ $model->status->name }}
    </x-card>
</x-app-layout>
