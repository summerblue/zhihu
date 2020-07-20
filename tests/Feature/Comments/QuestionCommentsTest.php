<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_comment_a_question()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $question = factory(Question::class)->state('published')->create();

        $this->post(route('question-comments.store', ['question' => $question]), [
            'content' => 'This is a answer.'
        ]);
    }

    /** @test */
    public function can_not_comment_an_unpublished_question()
    {
        $question = factory(Question::class)->state('unpublished')->create();
        $this->signIn($user = create(User::class))->withExceptionHandling();

        $response = $this->post(route('question-comments.store', ['question' => $question]), [
            'content' => 'This is a reply.'
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function signed_in_user_can_comment_a_published_question()
    {
        $question = factory(Question::class)->state('published')->create();
        $this->signIn($user = create(User::class));

        $response = $this->post(route('question-comments.store', ['question' => $question]), [
            'content' => 'This is a reply.'
        ]);

        $response->assertStatus(302);

        $comment = $question->comments()->where('user_id', $user->id)->first();

        $this->assertNotNull($comment);

        $this->assertEquals(1, $question->comments()->count());
    }

    /** @test */
    public function content_is_required_to_comment_a_question()
    {
        $question = factory(Question::class)->state('published')->create();

        $this->signIn()->withExceptionHandling();;

        $response = $this->post(route('question-comments.store', ['question' => $question]), [
            'content' => null
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }
}
