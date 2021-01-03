<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Profile') }}</x-title>
    </x-slot>

    <x-card>
        <x-card-title>{{ __('Edit Details') }}</x-card-title>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('put')

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name', auth()->user()->name)"
                    placeholder="e.g. John"
                    autocomplete="given-name"
                    required
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
                    :value="old('email', auth()->user()->email)"
                    placeholder="e.g. john.smith@example.com"
                    autocomplete="email"
                    required
                />
                <x-help-text>
                    {{ __(
                        'If you change this, we will send you an email '.
                        'asking you to verify your new address.'
                    ) }}
                </x-help-text>
                @error('email')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card>
        <x-card-title>{{ __('Change Password') }}</x-card-title>

        <form method="POST" action="{{ route('profile.update-password') }}">
            @csrf

            <!-- Current Password -->
            <div>
                <x-label for="current_password" :value="__('Current Password')" />
                <x-input
                    id="current_password"
                    class="block mt-1 w-full"
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    required
                />
                @error('current_password')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('New Password')" />
                <x-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                />
                @error('password')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <!-- Current Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm New Password')" />
                <x-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                />
                @error('password_confirmation')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Update Password') }}
                </x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
