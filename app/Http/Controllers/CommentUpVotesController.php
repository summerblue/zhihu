<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentUpVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Comment $comment)
    {
        $comment->voteUp(Auth::user());

        return response([], 201);
    }

    public function destroy(Comment $comment)
    {
        $comment->cancelVoteUp(Auth::user());

        return response([], 201);
    }
}
