<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Question;
use App\Translator\Translator;

class QuestionObserver
{
    public function created(Question $question)
    {
        if (! $question->slug) {
            dispatch(new TranslateSlug($question));
        }
    }
}
