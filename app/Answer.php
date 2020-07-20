<?php

namespace App;

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
}
