<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentDownVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Comment $comment)
    {
        $comment->voteDown(Auth::user());

        return response([], 201);
    }

    public function destroy(Comment $comment)
    {
        $comment->cancelVoteDown(Auth::user());

        return response([], 201);
    }
}
