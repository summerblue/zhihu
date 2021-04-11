<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Tests\Feature\VoteDownContractTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteDownContractTest;

    protected function getVoteDownUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/down-votes" : '/answers/1/down-votes';
    }

    protected function getModel()
    {
        return Answer::class;
    }

    protected function downVotes($answer)
    {
        return $answer->refresh()->votes('vote_down')->get();
    }
}
