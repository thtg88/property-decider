<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">

            <p>To get started you will need to set a password first.</p>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    autofocus
                />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-link href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </x-link>

                <x-button class="ml-4">
                    {{ __('Set Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
