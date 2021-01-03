<form action="{{ route('profile.notification-preferences.update') }}" method="post">
    @csrf
    @method('put')

    <div class="mt-2">
        <p>Get notified when:</p>
    </div>

    @foreach ($notification_types as $notification_type)
        @php($notification_preference = $user->notification_preferences->firstWhere(
            'type_id',
            $notification_type->id
        ))
        <input
            type="hidden"
            name="notification_preferences[{{ $notification_type->id }}][type_id]"
            value="{{ $notification_type->id }}"
        />
        <div class="mt-4">
            <x-label for="notification_preferences_{{ $notification_type->id }}_is_active">
                {{ $notification_type->description }}
                @if (in_array($notification_type->id, config('app.disabled_notification_types'), true))
                    <br>{{ __(
                        'This notification is currently not available / not working. '.
                        'Apologies for the inconvenience.'
                    ) }}
                @endif
            </x-label>
            <x-select
                name="notification_preferences[{{ $notification_type->id }}][is_active]"
                id="notification_preferences_{{ $notification_type->id }}_is_active"
                class="block mt-1"
            >
                <option value="0">No</option>
                <option
                    value="1"
                    {{
                        $notification_preference?->is_active === true ?
                            'selected' :
                            ''
                    }}
                >Yes</option>
            </x-select>
            @error('notification_preferences.'.$notification_type->id.'.type_id')
                <x-invalid-field>{{ $message }}</x-invalid-field>
            @enderror
            @error('notification_preferences.'.$notification_type->id.'.is_active')
                <x-invalid-field>{{ $message }}</x-invalid-field>
            @enderror
        </div>
    @endforeach

    @error('notification_preferences')
        <x-invalid-field>{{ $message }}</x-invalid-field>
    @enderror
    @error('notification_preferences.*')
        <x-invalid-field>{{ $message }}</x-invalid-field>
    @enderror

    <div class="flex items-center justify-start mt-4">
        <x-button>{{ __('Submit') }}</x-button>
    </div>
</form>
