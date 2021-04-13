<?php

namespace Tests\Unit;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vote;
use App\Models\Comment;

class AnswerTest extends TestCase
{
    use RefreshDatabase;
    use AddCommentContractTest;

    public function getCommentModel()
    {
        return create(Answer::class);
    }

    /** @test */
    public function it_knows_if_it_is_the_best()
    {
        $answer = create(Answer::class);

        $this->assertFalse($answer->isBest());

        $answer->question->update(['best_answer_id' => $answer->id]);

        $this->assertTrue($answer->isBest());
    }

    /** @test */
    public function an_answer_belongs_to_a_question()
    {
        $answer = create(Answer::class);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $answer->question());
    }

    /** @test */
    public function an_answer_belongs_to_an_owner()
    {
        $answer = create(Answer::class);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $answer->owner());
        $this->assertInstanceOf('App\Models\User', $answer->owner);
    }

    /** @test */
    public function can_vote_up_an_answer()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $this->assertDatabaseMissing('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer),
            'type' => 'vote_up',
        ]);

        $answer->voteUp(auth()->user());

        $this->assertDatabaseHas('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer),
            'type' => 'vote_up',
        ]);
    }

    /** @test */
    public function can_cancel_vote_up_an_answer()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $answer->voteUp(auth()->user());

        $answer->cancelVoteUp(auth()->user());

        $this->assertDatabaseMissing('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer)
        ]);
    }

    /** @test */
    public function can_know_it_is_voted_up()
    {
        $user = create(User::class);
        $answer = create(Answer::class);
        create(Vote::class, [
            'user_id' => $user->id,
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer)
        ]);

        $this->assertTrue($answer->refresh()->isVotedUp($user));
    }

    /** @test */
    public function can_vote_down_an_answer()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $this->assertDatabaseMissing('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer),
            'type' => 'vote_down',
        ]);

        $answer->voteDown(auth()->user());

        $this->assertDatabaseHas('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer),
            'type' => 'vote_down',
        ]);
    }

    /** @test */
    public function can_cancel_vote_down_answer()
    {
        $this->signIn();

        $answer = create(Answer::class);

        $answer->voteDown(auth()->user());

        $answer->cancelVoteDown(auth()->user());

        $this->assertDatabaseMissing('votes', [
            'user_id' => auth()->id(),
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer)
        ]);
    }

    /** @test */
    public function can_know_it_is_voted_down()
    {
        $user = create(User::class);
        $answer = create(Answer::class);
        create(Vote::class, [
            'user_id' => $user->id,
            'voted_id' => $answer->id,
            'voted_type' => get_class($answer),
            'type' => 'vote_down'
        ]);

        $this->assertTrue($answer->refresh()->isVotedDown($user));
    }

    /** @test */
    public function can_comment_an_answer()
    {
        $answer = create(Answer::class);

        $answer->comment('it is content', create(User::class));

        $this->assertEquals(1, $answer->refresh()->comments()->count());
    }

    /** @test */
    public function an_answer_has_many_comments()
    {
        $answer = create(Answer::class);

        create(Comment::class, [
            'commented_id' => $answer->id,
            'commented_type' => $answer->getMorphClass(),
            'content' => 'it is a comment'
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphMany', $answer->comments());
    }

    /** @test */
    public function can_get_comments_count_attribute()
    {
        $answer = create(Answer::class);

        $answer->comment('it is content', create(User::class));

        $this->assertEquals(1, $answer->refresh()->commentsCount);
    }
}
