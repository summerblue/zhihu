<?php

namespace App\Http\Controllers;

use App\Models\Answer;

class AnswerCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Answer $answer)
    {
        $comments = $answer->comments()->paginate(10);

        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $comments->items());

        return $comments;
    }

    public function store(Answer $answer)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);

        $comment =  $answer->comment(request('content'), auth()->user());

        return back();
    }
}
