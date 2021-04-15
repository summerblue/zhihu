<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities()->latest()->with('subject')->get();

        return view('profiles.show', [
            'profileUser'=> $user,
            'activities' => $activities
        ]);
    }
}
