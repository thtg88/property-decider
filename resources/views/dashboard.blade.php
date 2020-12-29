<x-app-layout>
    <x-slot name="header">
        <x-title>{{ __('Property Decider') }}</x-title>
    </x-slot>

    <x-card>
        <form method="POST" action="{{ route('properties.store') }}">
            @csrf

            <!-- URL -->
            <div>
                <x-label for="url" :value="__('Property URL')" />
                <x-input
                    id="url"
                    class="block mt-1 w-full"
                    type="url"
                    name="url"
                    :value="old('url')"
                    placeholder="e.g. https://zoopla.co.uk/for-sale/details/12345678"
                    required
                    autofocus
                />
                <x-help-text>
                    {{ __(
                        'Please copy the complete property\'s URL '.
                        'from the browser\'s address bar on the listing page, '.
                        'and paste it here. At the moment only the '.
                        'following provider(s) are supported: '.
                        implode(', ', \App\Actions\ProcessProperty\Utils::getProviderNames())
                    ) }}
                </x-help-text>
                @error('url')
                    <x-invalid-field>{{ $message }}</x-invalid-field>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Add Property') }}
                </x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
