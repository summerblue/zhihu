<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use Tests\Feature\VoteDownContractTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteDownContractTest;

    protected function getVoteDownUri($comment = null)
    {
        return $comment ? "/comments/{$comment->id}/down-votes" : '/comments/1/down-votes';
    }

    protected function getModel()
    {
        return Comment::class;
    }

    protected function downVotes($comment)
    {
        return $comment->refresh()->votes('vote_down')->get();
    }
}
