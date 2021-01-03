<?php

namespace App\Listeners;

use App\Events\PropertyStored;
use App\Models\User;
use App\Notifications\PropertyStoredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPropertyStoredNotificationListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\PropertyStored $event
     * @return void
     */
    public function handle(PropertyStored $event): void
    {
        $property = $event->getProperty();
        $creator = $property->user;

        // Make sure to only include the users that have the right notification preference set,
        // And exclude the property creator
        $creator->getUserGroups()->load(['user.notification_preferences'])
            ->where('user_id', '<>', $creator->id)
            ->pluck('user')
            ->filter()
            ->filter(static function (User $recipient): bool {
                return $recipient->notification_preferences->where(
                    'type_id',
                    config('app.notification_types.new_property_id')
                )->where('is_active', true)->count() > 0;
            })
            ->each(fn (User $recipient) => $recipient->notify(
                new PropertyStoredNotification($property, $creator)
            ));
    }
}
