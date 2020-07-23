<?php

namespace App\Listeners;

use App\Events\PostComment;
use App\Models\User;
use App\Notifications\YouWereMentionedInComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
