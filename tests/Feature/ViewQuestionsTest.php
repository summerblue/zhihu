<?php

namespace Tests\Feature;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_questions()
    {
        // 0. 抛出异常
        $this->withoutExceptionHandling();
        // 1. 访问链接 questions
        $test = $this->get('/questions');

        // 2. 正常返回 200
        $test->assertStatus(200);
    }

    /** @test */
    public function user_can_view_a_published_question()
    {
        $question = create(Question::class, ['published_at' => Carbon::parse('-1 week')]);

        $this->get('/questions/' . $question->id)
            ->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }

    /** @test */
    public function user_cannot_view_unpublished_question()
    {
        $question = create(Question::class, ['published_at' => null]);

        $this->withExceptionHandling()
            ->get('/questions/' . $question->id)
            ->assertStatus(404);
    }
}
