<?php

namespace App\Listeners;

use App\Events\CommentStored;
use App\Models\User;
use App\Notifications\CommentStoredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentStoredNotificationListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\CommentStored $event
     * @return void
     */
    public function handle(CommentStored $event)
    {
        $comment = $event->getComment();
        $property = $event->getProperty();
        $creator = $comment->user;

        // Make sure to only include the users that have the right notification preference set,
        // And exclude the property creator
        $creator->getUserGroups()->load(['user.notification_preferences'])
            ->where('user_id', '<>', $creator->id)
            ->pluck('user')
            ->filter()
            ->filter(static function (User $recipient) {
                return $recipient->notification_preferences->where(
                    'type_id',
                    config('app.notification_types.new_comment_id')
                )->where('is_active', true)->count() > 0;
            })
            ->each(static function (User $recipient) use (
                $comment,
                $property,
                $creator,
            ) {
                $recipient->notify(
                    new CommentStoredNotification($comment, $property, $creator)
                );
            });
    }
}
