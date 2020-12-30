<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Property Decider') }}</x-title>
    </x-slot>

    @if (in_array(auth()->user()->getUserGroups()->count(), [0, 1]))
        <x-card>
            Things are better when shared, why not
            <a
                href="{{ route('user-groups.create') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                invite someone
            </a>
        </x-card>
    @endif

    <x-card>
        @include('dashboard.store-property-form')
    </x-card>

    @if (auth()->user()->getUserGroups()->count() > 1)
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
        </x-card>
    @endif
</x-app-layout>
