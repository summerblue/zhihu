<?php

namespace App\Models;

use App\Notifications\QuestionWasUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use \App\Models\Traits\VoteTrait;

    protected $guarded = ['id'];

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'subscriptionsCount',
    ];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeDrafts($query, $userId)
    {
        return $query->where(['user_id' => $userId])->whereNull('published_at');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function markAsBestAnswer($answer)
    {
        $this->update([
            'best_answer_id' => $answer->id
        ]);
    }

    public function publish()
    {
        $this->update([
            'published_at' => Carbon::now()
        ]);
    }

    public function invitedUsers()
    {
        preg_match_all('/@([^\s.]+)/', $this->content,$matches);

        return $matches[1];
    }

    public function subscribe($userId)
    {
        $this->subscriptions()->create([
            'user_id' => $userId
        ]);

        return $this;
    }

    public function unsubscribe($userId)
    {
        $this->subscriptions()
            ->where('user_id', $userId)
            ->delete();

        return $this;
    }

    public function addAnswer($answer)
    {
        $answer = $this->answers()->create($answer);

        $this->subscriptions
            ->where('user_id', '!=', $answer->user_id)
            ->each
            ->notify($answer);

        return $answer;
    }

    public function isSubscribedTo($user)
    {
        if (! $user) {
            return false;
        }

        return $this->subscriptions()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getSubscriptionsCountAttribute()
    {
        return $this->subscriptions->count();
    }
}
