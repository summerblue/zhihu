<?php

namespace Tests\Feature\Questions;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\VoteUpContractTest;
use Tests\TestCase;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteUpContractTest;

    protected function getVoteUpUri($question = null)
    {
        return $question ? "/questions/{$question->id}/up-votes" : '/questions/1/up-votes';
    }

    protected function upVotes($question)
    {
        return $question->refresh()->votes('vote_up')->get();
    }

    protected function getModel()
    {
        return Question::class;
    }
}
