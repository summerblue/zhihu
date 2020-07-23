<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAvatarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validate(request(), [
            'avatar' => ['required', 'image', 'dimensions:min_width=200,min_height=200']
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars')
        ]);

        return back();
    }
}
