<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Profile') }}</x-title>
    </x-slot>

    <x-card>
        <x-card-title>{{ __('Edit Details') }}</x-card-title>
        @include('profile.edit.edit-details-form')
    </x-card>

    <x-card>
        <x-card-title>{{ __('Change Password') }}</x-card-title>
        @include('profile.edit.change-password-form')
    </x-card>

    <x-card>
        <x-card-title>{{ __('Notification Preferences') }}</x-card-title>
        @include('profile.edit.edit-notification-preferences-form')
    </x-card>
</x-app-layout>
