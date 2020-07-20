<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeDrafts($query, $userId)
    {
        return $query->where(['user_id' => $userId])->whereNull('published_at');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
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
}
