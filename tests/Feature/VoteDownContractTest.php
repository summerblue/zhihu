<?php

namespace Tests\Feature;

use App\Models\User;

trait VoteDownContractTest
{
    /** @test */
    public function guest_can_not_vote_down()
    {
        $this->withExceptionHandling()
            ->post($this->getVoteDownUri())
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_vote_down()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteDownUri($model))
            ->assertStatus(201);

        $this->assertCount(1, $this->downVotes($model));
    }

    /** @test */
    public function can_vote_down_only_once()
    {
        $this->signIn();

        $model = create($this->getModel());

        try {
            $this->post($this->getVoteDownUri($model));
            $this->post($this->getVoteDownUri($model));
        } catch (\Exception $e) {
            $this->fail('Can not vote up to same model twice.');
        }

        $this->assertCount(1, $this->downVotes($model));
    }

    /** @test */
    public function an_authenticated_user_can_cancel_vote_down()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteDownUri($model));

        $this->assertCount(1, $this->downVotes($model));

        $this->delete($this->getVoteDownUri($model));

        $this->assertCount(0, $this->downVotes($model));
    }

    /** @test */
    public function can_know_it_if_vote_down()
    {
        $this->signIn();

        $model = create($this->getModel());

        $this->post($this->getVoteDownUri($model));

        $this->assertTrue($model->refresh()->isVotedDown(auth()->user()));
    }

    /** @test */
    public function can_know_down_votes_count()
    {
        $model = create($this->getModel());

        $this->signIn();
        $this->post($this->getVoteDownUri($model));
        $this->assertEquals(1, $model->refresh()->downVotesCount);

        $this->signIn(create(User::class));
        $this->post($this->getVoteDownUri($model));

        $this->assertEquals(2, $model->refresh()->downVotesCount);
    }

    abstract protected function getVoteDownUri($model = null);

    abstract protected function downVotes($model);

    abstract protected function getModel();
}
