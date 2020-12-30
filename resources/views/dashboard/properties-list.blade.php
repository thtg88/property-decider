<div class="mt-4 grid grid-cols-1 divide-y divide-gray-500">
    @foreach ($properties as $property)
        <div class="py-2">
            <x-link href="{{ route('properties.show', $property) }}">
                {{ $property->title ?? $property->url }}
            </x-link>
            -
            Likes: {{ $property->getLikes()->count() }}
            Dislikes: {{ $property->getDislikes()->count() }}
        </div>
    @endforeach
</div>
