<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentStoredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Comment $comment
     * @param \App\Models\Property $property
     * @param \App\Models\User $creator
     * @return void
     */
    public function __construct(
        protected Comment $comment,
        protected Property $property,
        protected User $creator,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->creator->name.' Has Added A Comment')
            ->greeting('Hi '.$notifiable->name)
            ->line(
                $this->creator->name.' has added a comment to the property: '.
                '"'.($this->property->title ?? $this->property->url).'"'
            )
            ->line('> '.$this->comment->content)
            ->action(
                'View On Website',
                route('properties.show', $this->property).'#comments'
            )
            ->salutation('Regards,');
    }
}
