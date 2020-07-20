<?php

namespace App\Policies;

use App\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Question $question)
    {
        return (int) $user->id === (int) $question->user_id;
    }
}
