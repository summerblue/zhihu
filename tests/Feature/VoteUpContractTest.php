<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

trait VoteUpContractTest
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_vote_up()
    {
        $this->withExceptionHandling()
            ->post($this->getVoteUpUri())
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_vote_up()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteUpUri($model))
            ->assertStatus(201);

        $this->assertCount(1, $this->upVotes($model));
    }

    /** @test */
    public function can_vote_up_only_once()
    {
        $this->signIn();

        $model = create($this->getModel());

        try {
            $this->post($this->getVoteUpUri($model));
            $this->post($this->getVoteUpUri($model));
        } catch (\Exception $e) {
            $this->fail('Can not vote up to same model twice.');
        }

        $this->assertCount(1, $this->upVotes($model));
    }

    /** @test */
    public function an_authenticated_user_can_cancel_vote_up()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteUpUri($model));

        $this->assertCount(1, $this->upVotes($model));

        $this->delete($this->getVoteUpUri($model));

        $this->assertCount(0, $this->upVotes($model));
    }

    /** @test */
    public function can_know_it_if_voted_up()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteUpUri($model));

        $this->assertTrue($model->refresh()->isVotedUp(Auth::user()));
    }

    /** @test */
    public function can_know_up_votes_count()
    {
        $model = create($this->getModel());

        $this->signIn();
        $this->post($this->getVoteUpUri($model));
        $this->assertEquals(1, $model->refresh()->upVotesCount);

        $this->signIn(create(User::class));
        $this->post($this->getVoteUpUri($model));

        $this->assertEquals(2, $model->refresh()->upVotesCount);
    }

    abstract protected function getVoteUpUri($model = null);

    abstract protected function upVotes($model);

    abstract protected function getModel();
}
