<?php

namespace App\Observers;

use App\Models\Question;
use App\Jobs\TranslateSlug;

class QuestionObserver
{
    public function created(Question $question)
    {
        if (! $question->slug) {
            dispatch(new TranslateSlug($question));
        }
    }
}
