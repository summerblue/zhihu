<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\QuestionWasUpdated;

class Subscription extends Model
{
    use HasFactory;
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
