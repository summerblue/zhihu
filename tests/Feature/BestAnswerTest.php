<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestAnswerTest extends TestCase
{
    use  RefreshDatabase;

    /** @test */
    public function guests_can_not_mark_best_answer()
    {
        $question = create(Question::class);

        $answers = create(Answer::class, ['question_id' => $question->id], 2);

        $this->withExceptionHandling()
            ->post(route('best-answers.store', ['answer' => $answers[1]]), [$answers[1]])
            ->assertRedirect('/login');
    }

    /** @test */
    public function can_mark_one_answer_as_the_best()
    {
        $this->signIn();

        $question = create(Question::class, ['user_id' => auth()->id()]);

        $answers = create(Answer::class, ['question_id' => $question->id], 2);

        $this->assertFalse($answers[0]->isBest());
        $this->assertFalse($answers[1]->isBest());

        $this->postJson(route('best-answers.store', ['answer' => $answers[1]]), [$answers[1]]);

        $this->assertFalse($answers[0]->fresh()->isBest());
        $this->assertTrue($answers[1]->fresh()->isBest());
    }
}
