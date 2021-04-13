<?php

namespace App\Listeners;

use App\Events\PostComment;
use App\Models\User;
use App\Notifications\YouWereMentionedInComment;

class NotifyMentionedUsersInComment
{
    public function handle(PostComment $event)
    {
        User::whereIn('name', $event->comment->invitedUsers())
            ->get()
            ->each(function ($user) use ($event) {

                $user->notify(new YouWereMentionedInComment($event->comment));
            });
    }
}
