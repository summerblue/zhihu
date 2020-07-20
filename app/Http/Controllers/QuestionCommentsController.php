<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($questionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);

        $question = Question::published()->findOrFail($questionId);

        $comment = $question->comment(request('content'), auth()->user());

        return back();
    }
}
