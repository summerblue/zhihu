<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;
    use Traits\VoteTrait;
    use Traits\CommentTrait;
    use Traits\RecordActivityTrait;

    protected $guarded = ['id'];
    protected $table = 'answers';

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'commentsCount',
        'commentEndpoint',
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
}
