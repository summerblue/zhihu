<?php

namespace App\Http\Controllers;

use App\Models\Answer;

class AnswerCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
