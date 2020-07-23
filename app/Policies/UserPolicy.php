<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $loginUser, User $user)
    {
        return (int) $loginUser->id === (int) $user->id;
    }
}
