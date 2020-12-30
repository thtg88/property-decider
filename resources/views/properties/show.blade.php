<x-app-layout>
    <x-slot name="header">
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <x-title>{{ $model->title ?? $model->url }}</x-title>
            </div>
        </div>
        <div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
            <form action="{{ route('properties.reprocess', $model) }}" method="post">
                @csrf
                <x-buttons.primary-button type="submit" data-confirm="Are you sure you want to reprocess this property details? This will overwrite existing information">
                    Reprocess
                </x-buttons.primary-button>
            </form>
        </div>
        <div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
            <form action="{{ route('properties.destroy', $model) }}" method="post">
                @csrf
                @method('delete')
                <x-buttons.danger-button type="submit" data-confirm="Are you sure you want to remove this property?">
                    Remove
                </x-buttons.danger-button>
            </form>
        </div>
    </x-slot>

    <x-card>
        @if ($model->status_id !== config('app.statuses.completed_id'))
            <p><strong>Status</strong>: {{ $model->status->name }}</p>
        @endif
        <p class="mt-2">
            <strong>Description</strong>:
            {{ $model->description }}
        </p>
    </x-card>
</x-app-layout>
