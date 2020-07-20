<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_vote_down()
    {
        $this->withExceptionHandling()
            ->post('/answers/1/down-votes')
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_vote_down()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $this->post("/answers/{$answer->id}/down-votes")
            ->assertStatus(201);

        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());
    }
}
