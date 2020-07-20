<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function markAsBestAnswer($answer)
    {
        $this->update([
            'best_answer_id' => $answer->id
        ]);
    }
}
