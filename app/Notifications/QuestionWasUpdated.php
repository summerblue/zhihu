<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionWasUpdated extends Notification
{
    use Queueable;

    protected $question;

    protected $answer;

    public function __construct($question, $answer)
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'answer_id' => $this->answer->id,
            'answer_content' => $this->answer->content,
            'user_id' => $this->answer->owner->id,
            'user_name' => $this->answer->owner->name,
            'question_id' => $this->question->id,
            'question_title' => $this->question->title,
        ];
    }
}
