<p class="mt-4">
    You have {{ $user_preference->is_liked === false ? 'dis' : '' }}liked this property.
</p>

<form method="POST" action="{{ route('property-preferences.destroy', $user_preference) }}">
    @csrf
    @method('delete')

    <div class="flex items-center justify-start mt-4">
        <x-button class="ml-3">
            {{ __('I\'ve change my mind') }}
        </x-button>
    </div>
</form>

<p class="mt-2">
    Why did you {{ $user_preference->is_liked === false ? 'dis' : '' }}like this property?
    Leave a <x-link href="#comments">comment</x-link>
</p>
