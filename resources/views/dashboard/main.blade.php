<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Property Decider') }}</x-title>
    </x-slot>

    @if (in_array($user_groups->count(), [0, 1]))
        <x-card>
            Things are better when shared, why not
                <x-link href="{{ route('user-groups.create') }}">
                    invite someone
                </x-link>
        </x-card>
    @endif

    <x-card>
        @include('dashboard.store-property-form')
    </x-card>

        <x-card>
            <p>Your current group is formed of:</p>
            <ul class="mt-2" style="list-style-type: none;">
                @foreach (auth()->user()->getUserGroups() as $user_group)
                    <li>
                        <x-icons.verified-badge class="w-5 h-5 inline" />
                        {{ $user_group->user->name }}
                        @if (auth()->user()->id === $user_group->user_id)
                            (Yourself)
                        @endif
                    </li>
                @endforeach
            </ul>
    @if ($user_groups->count() > 1)
        <x-card>
            <x-card-title>Your Group</x-card-title>
            @include('dashboard.user-groups-list')
        </x-card>
    @endif
</x-app-layout>
