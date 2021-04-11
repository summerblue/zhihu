<?php

namespace Tests\Feature\Answers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Answer;

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

    /** @test */
    public function an_authenticated_user_can_cancel_vote_down()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $this->post("/answers/{$answer->id}/down-votes");

        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());

        $this->delete("/answers/{$answer->id}/down-votes");

        $this->assertCount(0, $answer->refresh()->votes('vote_down')->get());
    }


    /** @test */
    public function can_vote_down_only_once()
    {
        $this->signIn();

        $answer = create(Answer::class);

        try {
            $this->post("/answers/{$answer->id}/down-votes");
            $this->post("/answers/{$answer->id}/down-votes");
        } catch (\Exception $e) {
            $this->fail('Can not vote down twice.');
        }

        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());
    }
}
