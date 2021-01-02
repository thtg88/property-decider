<form action="{{ route('properties.comments.store', $model) }}" method="post">
    @csrf

    <!-- Content -->
    <div class="mt-4">
        <x-label for="content" :value="__('Add a comment')" />
        <x-input
            id="content"
            class="block mt-1 w-full"
            type="text"
            name="content"
            :value="old('content')"
            placeholder="e.g. I love this!"
            required
        />
        @error('content')
            <x-invalid-field>{{ $message }}</x-invalid-field>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button class="ml-3">{{ __('Comment') }}</x-button>
    </div>
</form>
