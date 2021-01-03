<x-app-layout>
    <x-slot name="header">
        <x-title>{{ config('app.name') }}</x-title>
    </x-slot>

    @if (in_array($user_groups->count(), [0, 1]))
        <x-card>
            <p>
                Things are better when shared, why not
                <x-link href="{{ route('user-groups.create') }}">
                    invite someone
                </x-link>
            </p>
        </x-card>
    @endif

    <x-card>
        @include('dashboard.store-property-form')
    </x-card>

    @if ($new_properties->count() > 0)
        <x-card>
            <x-card-title>{{ __('New Properties') }}</x-card-title>

            <p class="mt-2">
                You have not expressed your preference to these properties,
                have a look at them below,
                and let your group know what you think!
            </p>

            @include('dashboard.new-properties-list')
        </x-card>
    @endif

    @if ($voted_properties->count() > 0)
        <x-card>
            <x-card-title>Properties</x-card-title>

            @include('dashboard.voted-properties-list')
        </x-card>
    @endif

    @if ($user_groups->count() > 1)
        <x-card>
            <x-card-title>Your Group</x-card-title>

            @include('dashboard.user-groups-list')

            <p class="mt-2">
                You can always
                <x-link href="{{ route('user-groups.create') }}">invite someone new</x-link>
            </p>
        </x-card>
    @endif
</x-app-layout>
