<?php

namespace Tests\Feature\Answers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Answer;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_vote_up()
    {
        $this->withExceptionHandling()
            ->post('/answers/1/up-votes')
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_vote_up()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $this->post("/answers/{$answer->id}/up-votes")
            ->assertStatus(201);

        $this->assertCount(1, $answer->refresh()->votes('vote_up')->get());
    }
}
