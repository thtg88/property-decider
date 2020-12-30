<p>Your current group is formed of:</p>
<div class="mt-4 grid grid-cols-1 divide-y divide-gray-300">
    @foreach ($user_groups as $user_group)
        <div class="py-2">
            <x-icons.verified-badge class="w-5 h-5 inline" />
            {{ $user_group->user->name }}
            @if (auth()->user()->id === $user_group->user_id)
                (Yourself)
            @endif
        </div>
    @endforeach
</div>
