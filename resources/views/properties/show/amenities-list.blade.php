<div class="mt-4 grid grid-cols-1 divide-y divide-gray-300">
    @foreach ($model->property_amenities as $property_amenity)
        <div class="py-2">
            {{ $property_amenity->amenity->name ?? 'N/A' }}
        </div>
    @endforeach
</div>
