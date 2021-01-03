<?php

namespace App\Notifications;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyStoredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Property $property
     * @param \App\Models\User $creator
     * @return void
     */
    public function __construct(
        protected Property $property,
        protected User $creator
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->creator->name.' Has Added A New Property')
            ->greeting('Hi '.$notifiable->name)
            ->line(
                $this->creator->name.' has added a property: '.
                '"'.($this->property->title ?? $this->property->url).'"'
            )
            ->action(
                'View On Website',
                route('properties.show', $this->property)
            )
            ->line('You can let your group know what you think, by leaving a preference or a comment.')
            ->salutation('Regards,');
    }
}
