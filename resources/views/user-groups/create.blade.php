<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Invite Someone To Your Group') }}</x-title>
    </x-slot>

    <x-card>
        <form method="POST" action="{{ route('user-groups.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    placeholder="e.g. John"
                    autocomplete="given-name"
                    required
                    autofocus
                />
                @error('name')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="e.g. john.smith@example.com"
                    autocomplete="email"
                    required
                />
                <x-help-text>
                    {{ __('We\'ll send them them an email asking to join your group on '.config('app.name')) }}
                </x-help-text>
                @error('email')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Invite') }}
                </x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
