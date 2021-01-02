<form action="{{ route('properties.like', $model) }}" method="post" class="inline">
    @csrf
    <button type="submit" title="Like this property" class="mt-4 w-20">
        <x-icons.check />
    </button>
</form>
