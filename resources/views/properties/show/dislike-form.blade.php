<form action="{{ route('properties.dislike', $model) }}" method="post" class="ml-6 inline">
    @csrf
    <button type="submit" title="Dislike this property" class="mt-4 w-20">
        <x-icons.times />
    </button>
</form>
