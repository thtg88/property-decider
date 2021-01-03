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
