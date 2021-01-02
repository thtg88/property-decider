<x-app-layout>
    <x-slot name="header">
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <x-title>{{ $model->title ?? $model->url }}</x-title>
            </div>
        </div>
        @include('properties.show.header-actions')
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

            <p class="mt-2">
                Why did you {{ $user_preference->is_liked === false ? 'dis' : '' }}like this property?
                Leave a <x-link href="#comments">comment</x-link>
            </p>
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

    {{-- If there's at least one preference which is not mine --}}
    @if (
        ($model->property_preferences->count() > 0 && $user_preference === null) ||
        ($model->property_preferences->count() > 1 && $user_preference !== null)
    )
        <x-card>@include('properties.show.preferences')</x-card>
    @endif

    <x-card>
        <x-card-title id="comments">{{ __('Comments') }}</x-card-title>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @foreach ($model->comments as $comment)
            <p class="mt-4">
                <strong>{{ $comment->user->name ?? 'N/A' }}</strong>
                ({{ $comment->created_at->diffForHumans() }}):
                {{ $comment->content }}
            </p>
        @endforeach

        <form action="{{ route('properties.comments.store', $model) }}" method="post">
            @csrf

            <!-- Content -->
            <div class="mt-4">
                <x-label for="content" :value="__('Add a comment')" />
                <x-input
                    id="content"
                    class="block mt-1 w-full"
                    type="text"
                    name="content"
                    :value="old('content')"
                    placeholder="e.g. I love this!"
                    required
                />
                @error('content')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">{{ __('Comment') }}</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
