<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Answer $answer)
    {
        return (int) $user->id === (int) $answer->user_id;
    }
}
