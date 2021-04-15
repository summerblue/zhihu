<?php

namespace App\Observers;

use App\Models\Answer;

class AnswerObserver
{
    public function created(Answer $answer)
    {
        if ($answer->owner) {
            $answer->activities()->create([
                'user_id' => $answer->owner->id,
                'type' => 'created_answer'
            ]);
        }
    }
}
