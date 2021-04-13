<?php

namespace Tests\Feature\Questions;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

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

    private function publishQuestion($overrides = [])
    {
        return Question::factory()->published()->create($overrides);
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
}
