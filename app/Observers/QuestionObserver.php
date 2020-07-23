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

    public function updated(Question $question)
    {
        if ($this->publishedJustNow($question)) {

            $question->activities()->create([
                'user_id' => $question->creator->id,
                'type' => 'published_question'
            ]);
        }
    }

    protected function publishedJustNow($question)
    {
        return $question->published_at != null &&
            $question->published_at->format('Y-m-d H:m:s') == $question->updated_at->format('Y-m-d H:m:s');
    }
}
