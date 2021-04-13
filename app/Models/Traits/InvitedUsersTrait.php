<?php

namespace App\Models\Traits;

trait InvitedUsersTrait
{
    public function invitedUsers()
    {
        preg_match_all('/@([^\s.]+)/', $this->content,$matches);

        return $matches[1];
    }
}
