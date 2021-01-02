@foreach ($model->comments as $comment)
    <p class="mt-4">
        <strong>{{ $comment->user->name ?? 'N/A' }}</strong>
        ({{ $comment->created_at->diffForHumans() }}):
        {{ $comment->content }}
    </p>
@endforeach
