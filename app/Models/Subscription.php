<?php

namespace App\Models;

use App\Notifications\QuestionWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notify($answer)
    {
        $this->user->notify(new QuestionWasUpdated($answer->question, $answer));
    }
}
