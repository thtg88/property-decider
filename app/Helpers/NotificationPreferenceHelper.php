<?php

namespace App\Helpers;

use App\Models\NotificationPreference;
use App\Models\NotificationType;
use App\Models\User;

class NotificationPreferenceHelper
{
    /**
     * Create notification preferences for all available notification types,
     * from the given user.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function createAll(User $user): void
    {
        // Create non-active notification preferences for each type
        NotificationType::orderBy('id')->get()->each(
            fn (NotificationType $type) => NotificationPreference::create([
                'is_active' => false,
                'type_id' => $type->id,
                'user_id' => $user->id,
            ])
        );
    }
}
