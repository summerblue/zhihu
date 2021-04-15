<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserAvatarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('update', $user);

        $this->validate(request(), [
            'avatar' => ['required', 'image', 'dimensions:min_width=200,min_height=200']
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return back()->with('flash', '头像上传成功！');;
    }
}
