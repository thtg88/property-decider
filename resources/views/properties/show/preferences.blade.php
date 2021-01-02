@foreach ($model->property_preferences as $property_preference)
    <p class="mt-2">
        @if ($property_preference->is_liked === true)
            <x-icons.check class="w-10 h-10 inline mr-2" />
        @else
            <x-icons.times class="w-10 h-10 inline mr-2" />
        @endif
        {{ $property_preference->user->name }}
        {{ $property_preference->is_liked === false ? 'dis' : '' }}liked this property
    </p>
@endforeach
