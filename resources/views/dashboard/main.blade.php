<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Property Decider') }}</x-title>
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

    @if ($properties->count() > 0)
        <x-card>
            <x-card-title>Properties</x-card-title>
            @include('dashboard.properties-list')
        </x-card>
    @endif

    @if ($user_groups->count() > 1)
        <x-card>
            <x-card-title>Your Group</x-card-title>
            @include('dashboard.user-groups-list')
        </x-card>
    @endif
</x-app-layout>
