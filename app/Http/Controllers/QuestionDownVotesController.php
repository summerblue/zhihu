<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionDownVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->voteDown(Auth::user());

        return response([], 201);
    }

    public function destroy(Question $question)
    {
        $question->cancelVoteDown(Auth::user());

        return response([], 201);
    }
}
