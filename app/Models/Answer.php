<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = ['id'];

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function voteUp($user)
    {
        $this->votes('vote_up')->create(['user_id' => $user->id, 'type' => 'vote_up']);
    }

    public function cancelVoteUp($user)
    {
        $this->votes('vote_up')->where(['user_id' => $user->id, 'type' => 'vote_up'])->delete();
    }

    public function votes($type)
    {
        return $this->morphMany(Vote::class, 'voted')->whereType($type);
    }
}
