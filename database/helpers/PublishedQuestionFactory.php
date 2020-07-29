<?php

namespace Helpers;

use App\Models\Question;

class PublishedQuestionFactory
{
    public static function createPublished($overrides = [])
    {
        $question = factory(Question::class)->create($overrides);
        $question->publish();

        return $question;
    }

    public static function createUnpublished($overrides = [])
    {
        $question = factory(Question::class)->state('unpublished')->create($overrides);

        return $question;
    }
}

