<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\VoteUpContractTest;
use Tests\TestCase;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteUpContractTest;

    protected function getAffectModel()
    {
        return Comment::class;
    }

    protected function getVoteUpUri($comment = null)
    {
        return $comment ? "/comments/{$comment->id}/up-votes" : '/comments/1/up-votes';
    }

    protected function upVotes($comment)
    {
        return $comment->refresh()->votes('vote_up')->get();
    }

    protected function getModel()
    {
        return Comment::class;
    }
}
