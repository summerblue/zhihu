<?php

namespace App\Observers;

use App\Models\Question;
use App\Translator\Translator;

class QuestionObserver
{
    public function created(Question $question)
    {
        if (! $question->slug) {
            $question->update([
                'slug' => app(Translator::class)->translate($question->title)
            ]);
        }
    }
}
