<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;
    use Traits\VoteTrait;

    // 这里也放开了属性保护
    protected $guarded = ['id'];

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

        return $answer;
    }
}
