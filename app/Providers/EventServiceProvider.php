<?php

namespace App\Providers;

use App\Events\PostComment;
use App\Events\PublishQuestion;
use App\Listeners\NotifyInvitedUsers;
use App\Listeners\NotifyMentionedUsersInComment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PublishQuestion::class => [
            NotifyInvitedUsers::class
        ],
        PostComment::class => [
            NotifyMentionedUsersInComment::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
