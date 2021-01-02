<div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
    <form action="{{ route('properties.reprocess', $model) }}" method="post">
        @csrf
        <x-buttons.primary-button-link href="{{ $model->url }}" target="_blank" rel="noopener noreferrer">
            View on website
            <x-icons.external-link class="w-4" />
        </x-buttons.primary-button-link>
    </form>
</div>
<div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
    <form action="{{ route('properties.reprocess', $model) }}" method="post">
        @csrf
        <x-buttons.primary-button type="submit" data-confirm="Are you sure you want to reprocess this property details? This will overwrite existing information">
            Reprocess
        </x-buttons.primary-button>
    </form>
</div>
<div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
    <form action="{{ route('properties.destroy', $model) }}" method="post">
        @csrf
        @method('delete')
        <x-buttons.danger-button type="submit" data-confirm="Are you sure you want to remove this property?">
            Remove
        </x-buttons.danger-button>
    </form>
</div>
