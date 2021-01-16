<?php

namespace App\Notifications;

use App\Models\UserGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected string $token,
        protected UserGroup $user_group,
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
            ->subject(
                'You have been invited to '.config('app.name').' '.
                'by '.($this->user_group->inviter->name ?? 'N/A')
            )
            ->greeting('Hi '.$notifiable->name)
            ->line(
                ($this->user_group->inviter->name ?? 'N/A').' '.
                '('.($this->user_group->inviter->email ?? 'N/A').')'.
                ' has invited you to join them on '.config('app.name').
                ' – a system to make a decision about your next property move.'
            )
            ->action(
                'Accept invite and set password',
                route('invites.accept', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ])
            )
            ->line(
                'This invitation will expire in '.(config(
                    'auth.passwords.'.
                    config('auth.defaults.passwords').
                    '.expire'
                ) / 60).' hours.'
            )
            ->salutation('Regards,');
    }
}
