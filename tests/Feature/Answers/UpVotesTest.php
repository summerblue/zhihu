<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\VoteUpContractTest;
use Tests\TestCase;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteUpContractTest;

    protected function getAffectModel()
    {
        return Answer::class;
    }

    protected function getVoteUpUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/up-votes" : '/answers/1/up-votes';
    }

    protected function upVotes($answer)
    {
        return $answer->refresh()->votes('vote_up')->get();
    }

    protected function getModel()
    {
        return Answer::class;
    }
}


