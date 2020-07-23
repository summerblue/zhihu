<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class YouWereMentionedInComment extends Notification
{
    use Queueable;

    private $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $commentOwner = $this->comment->owner;

        return [
            'user_id' => $commentOwner->id,
            'user_name' => $commentOwner->name,
            'user_avatar' => $commentOwner->userAvatar,
            'content' => $this->comment->content,
        ];
    }
}
