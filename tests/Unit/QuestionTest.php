<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_question_has_many_answers()
    {
        $question = factory(Question::class)->create();

        factory(Answer::class)->create(['question_id' => $question->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $question->answers());
    }
}
