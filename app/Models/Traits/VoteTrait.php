<?php

namespace App\Models\Traits;

use App\Models\Vote;

trait VoteTrait
{
    public function vote($user, $type)
    {
        $attributes = ['user_id' => $user->id];

        if (! $this->votes($type)->where($attributes)->exists()) {
            $this->votes($type)->create(['user_id' => $user->id, 'type' => $type]);
        }
    }

    public function cancelVoteUp($user)
    {
        $this->cancelVote($user, 'vote_up');
    }

    public function cancelVoteDown($user)
    {
        $this->cancelVote($user, 'vote_down');
    }

    public function cancelVote($user, $type)
    {
        $attributes = ['user_id' => $user->id];

        $this->votes($type)->where($attributes)->delete();
    }

    public function votes($type)
    {
        return $this->morphMany(Vote::class, 'voted')->whereType($type);
    }

    public function voteUp($user)
    {
        $this->vote($user, 'vote_up');
    }

    public function voteDown($user)
    {
        $this->vote($user, 'vote_down');
    }

    public function isVotedUp($user)
    {
        return $this->isVoted($user, 'vote_up');
    }

    public function isVotedDown($user)
    {
        return $this->isVoted($user, 'vote_down');
    }

    public function isVoted($user, $type)
    {
        if (! $user) {
            return false;
        }

        return $this->votes($type)->where('user_id', $user->id)->exists();
    }

    public function getUpVotesCountAttribute()
    {
        return $this->votes('vote_up')->count();
    }

    public function getDownVotesCountAttribute()
    {
        return $this->votes('vote_down')->count();
    }
}
