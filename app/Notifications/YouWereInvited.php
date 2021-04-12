<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouWereInvited extends Notification
{
    use Queueable;

    private $question;

    public function __construct($question)
    {
        $this->question = $question;
    }

    public function via()
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $questionCreator = $this->question->creator;

        return [
            'user_id' => $questionCreator->id,
            'user_name' => $questionCreator->name,
            'user_avatar' => $questionCreator->userAvatar,
            'question_link' => "/questions/$this->question->id",
            'question_title' => $this->question->title,
        ];
    }
}
