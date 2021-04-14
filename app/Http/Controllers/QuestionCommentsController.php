<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function store($questionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);

        $question = Question::published()->findOrFail($questionId);

        $comment = $question->comment(request('content'), auth()->user());

        return $comment->load('owner');
    }

    public function index(Question $question)
    {
        $comments = $question->comments()->paginate(10);

        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $comments->items());

        return $comments;
    }
}
