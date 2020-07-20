<?php

namespace Tests\Feature;

use App\Question;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_post_an_answer_to_a_question()
    {
        $question = factory(Question::class)->create();
        $user = factory(User::class)->create();

        $response = $this->post("/questions/{$question->id}/answers",[
            'user_id' => $user->id,
            'content' => 'This is a answer.'
        ]);

        $response->assertStatus(201);

        $answer = $question->answers()->where('user_id',$user->id)->first();
        $this->assertNotNull($answer);

        $this->assertEquals(1,$question->answers()->count());
    }
}
