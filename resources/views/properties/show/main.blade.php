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
            @include('properties.show.status')
        @endif

        <div class="mt-2">
            {!! strip_tags($model->description, '<br><strong>') !!}
        </div>

        @include('properties.show.amenities-list')

        <p class="mt-4 text-gray-500">
            Added by {{ $model->user->name }}
            {{ $model->created_at->diffForHumans() }}
        </p>

        @if ($user_preference !== null)
            @include('properties.show.current-preference')
        @else
            @include('properties.show.like-form')
            @include('properties.show.dislike-form')
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

        @include('properties.show.comments-list')

        @include('properties.show.comments-create-form')
    </x-card>

    @if (
        $model->status_id !== config('app.statuses.completed_id') &&
        $model->status_id !== config('app.statuses.failed_id')
    )
        <script>
            window.addEventListener('load', function () {
                window.setTimeout(function () {
                    location.reload();
                }, 5000);
            });
        </script>
    @endif
</x-app-layout>
