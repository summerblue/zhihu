<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_comment_a_answer()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $answer = create(Answer::class);

        $this->post(route('answer-comments.store', ['answer' => $answer]), [
            'content' => 'This is a answer.'
        ]);
    }

    /** @test */
    public function signed_in_user_can_comment_an_answer()
    {
        $answer = create(Answer::class);
        $this->signIn($user = create(User::class));

        $response = $this->post(route('answer-comments.store', ['answer' => $answer]), [
            'content' => 'This is a reply.'
        ]);

        $response->assertStatus(201);

        $comment = $answer->comments()->where('user_id', $user->id)->first();

        $this->assertNotNull($comment);

        $this->assertEquals(1, $answer->comments()->count());
    }

    /** @test */
    public function content_is_required_to_comment_a_answer()
    {
        $answer = create(Answer::class);

        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('answer-comments.store', ['answer' => $answer]), [
            'content' => null
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }
}
