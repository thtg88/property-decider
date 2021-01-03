<?php

namespace App\Providers;

use App\Events\CommentStored;
use App\Events\PropertyStored;
use App\Listeners\SendCommentStoredNotificationListener;
use App\Listeners\SendPropertyStoredNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentStored::class => [
            SendCommentStoredNotificationListener::class,
        ],
        PropertyStored::class => [
            SendPropertyStoredNotificationListener::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
