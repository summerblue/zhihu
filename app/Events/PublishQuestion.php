<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublishQuestion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question;

    public function __construct($question)
    {
        $this->question = $question;
    }
}
