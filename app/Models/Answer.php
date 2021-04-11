<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

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

    public function votes($type)
    {
        return $this->morphMany(Vote::class, 'voted')->whereType($type);
    }
}
