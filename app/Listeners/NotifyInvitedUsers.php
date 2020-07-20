<?php

namespace App\Listeners;

use App\Events\PublishQuestion;
use App\Notifications\YouWereInvited;
use App\Models\User;

class NotifyInvitedUsers
{
    public function handle(PublishQuestion $event)
    {
        User::whereIn('name', $event->question->invitedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereInvited($event->question));
            });
    }
}
