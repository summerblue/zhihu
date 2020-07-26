<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
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

    /** @test */
    public function only_the_question_creator_can_mark_a_best_answer()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $question = create(Question::class, ['user_id' => auth()->id()]);

        $answer = create(Answer::class, ['question_id' => $question->id]);

        // 另一个用户
        $this->signIn(create(User::class));

        $this->postJson(route('best-answers.store', ['answer' => $answer]), [$answer])
            ->assertStatus(403);

        $this->assertFalse($answer->fresh()->isBest());
    }
}
