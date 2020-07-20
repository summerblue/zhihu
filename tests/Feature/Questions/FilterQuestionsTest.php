<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_published_questions_without_any_filter()
    {
        create(Question::class, ['published_at' => Carbon::now()], 10);
        $unpublishedQuestion = create(Question::class);

        create(Question::class, ['published_at' => Carbon::now()], 30);

        // 创建的第一个 Question
        $publishedQuestion = Question::find(1);

        $response = $this->get('/questions');
        $response->assertSee($publishedQuestion->title)
            ->assertDontSee($unpublishedQuestion->title);

        $result = $response->data('questions')->toArray();
        $this->assertEquals(40, $result['total']);

        $this->assertCount(20, $result['data']);
    }

    /** @test */
    public function user_can_filter_questions_by_category()
    {
        $category = create(Category::class);
        $questionInCategory = $this->publishQuestion(['category_id' => $category->id]);
        $questionNotInCategory = $this->publishQuestion();

        $this->get('/questions/' . $category->slug)
            ->assertSee($questionInCategory->title)
            ->assertDontSee($questionNotInCategory->title);
    }

    /** @test */
    public function user_can_filter_questions_by_username()
    {
        $this->signIn($john = create(User::class, ['name' => 'john']));

        $questionByJohn = $this->publishQuestion(['user_id' => $john->id]);
        $questionNotByJohn = $this->publishQuestion();

        $this->get('questions?by=john')
            ->assertSee($questionByJohn->title)
            ->assertDontSee($questionNotByJohn->title);
    }

    /** @test */
    public function user_can_filter_questions_by_popularity()
    {
        // Question without answers
        $this->publishQuestion();

        // Question with two answers
        $questionOfTwoAnswers = $this->publishQuestion();
        create(Answer::class, ['question_id' => $questionOfTwoAnswers->id], 2);

        // Question with three answers
        $questionOfThreeAnswers = $this->publishQuestion();
        create(Answer::class, ['question_id' => $questionOfThreeAnswers->id], 3);

        $response = $this->get('questions?popularity=1');

        $questions = $response->data('questions')->items();

        $this->assertEquals([3,2,0], array_column($questions, 'answers_count'));
    }

    /** @test */
    public function a_user_can_filter_unanswered_questions()
    {
        $this->publishQuestion();

        $questionOfTwoAnswers = $this->publishQuestion();;
        create(Answer::class, ['question_id' => $questionOfTwoAnswers->id], 2);

        $response = $this->get('questions?unanswered=1');

        $result = $response->data('questions')->toArray();

        $this->assertEquals(1, $result['total']);
    }

    private function publishQuestion($overrides = [])
    {
        return factory(Question::class)->state('published')->create($overrides);
    }
}
