<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use \App\Models\Traits\VoteTrait;

    protected $guarded = ['id'];

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'commentsCount',
    ];

    protected static function boot()
    {
        parent::boot(); //

        static::created(function ($reply) {
            $reply->question->increment('answers_count');
        });
    }

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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commented');
    }

    public function comment($content, $user)
    {
        $comment =  $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content
        ]);

        return $comment;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }
}
