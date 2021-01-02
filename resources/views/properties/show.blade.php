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
                <x-buttons.primary-button-link href="{{ $model->url }}" target="_blank" rel="noopener noreferrer">
                    View on website
                    <x-icons.external-link class="w-4" />
                </x-buttons.primary-button-link>
            </form>
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
        <x-card-title>&pound;{{ number_format($model->price) }}</x-card-title>
        @if ($model->status_id !== config('app.statuses.completed_id'))
            <p><strong>Status</strong>: {{ $model->status->name }}</p>
        @endif
        <div class="mt-2">
            {!! strip_tags($model->description, '<br><strong>') !!}
        </div>
        <div class="mt-4 grid grid-cols-1 divide-y divide-gray-300">
            @foreach ($model->property_amenities as $property_amenity)
                <div class="py-2">
                    {{ $property_amenity->amenity->name ?? 'N/A' }}
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-gray-500">
            Added by {{ $model->user->name }}
            {{ $model->created_at->diffForHumans() }}
        </p>

        @if ($user_preference !== null)
            <p class="mt-4">
                You have {{ $user_preference->is_liked === false ? 'dis' : '' }}liked this property.
            </p>

            <form method="POST" action="{{ route('property-preferences.destroy', $user_preference) }}">
                @csrf
                @method('delete')

                <div class="flex items-center justify-start mt-4">
                    <x-button class="ml-3">
                        {{ __('I\'ve change my mind') }}
                    </x-button>
                </div>
            </form>
        @else
            <form action="{{ route('properties.like', $model) }}" method="post" class="inline">
                @csrf
                <button type="submit" title="Like this property" class="mt-4 w-20">
                    <x-icons.check />
                </button>
            </form>

            <form action="{{ route('properties.dislike', $model) }}" method="post" class="ml-6 inline">
                @csrf
                <button type="submit" title="Dislike this property" class="mt-4 w-20">
                    <x-icons.times />
                </button>
            </form>
        @endif
    </x-card>

    @if (
        (
            $model->property_preferences->count() > 0 &&
            $user_preference === null
        ) ||
        (
            $model->property_preferences->count() > 1 &&
            $user_preference !== null
        )
    )
        <x-card>
            @foreach ($model->property_preferences as $property_preference)
                <p class="mt-2">
                    @if ($property_preference->is_liked === true)
                        <x-icons.check class="w-10 h-10 inline mr-2" />
                    @else
                        <x-icons.times class="w-10 h-10 inline mr-2" />
                    @endif
                    {{ $property_preference->user->name }}
                    {{ $property_preference->is_liked === false ? 'dis' : '' }}liked this property
                </p>
            @endforeach
        </x-card>
    @endif
</x-app-layout>
