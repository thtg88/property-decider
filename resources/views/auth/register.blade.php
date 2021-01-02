<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
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
                    required
                    autofocus
                />
                @error('name')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                />
                @error('email')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

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
                />
                @error('password')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            @if (config('captcha.mode') === true)
                <div class="mt-4 mx-auto inline-block">
                    {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                </div>
                @error('g-recaptcha-response')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-link href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </x-link>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs() !!}
</x-guest-layout>
