<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($questionId)
    {
        $question = Question::published()->findOrFail($questionId);

        $this->validate(request(),[
            'content' => 'required'
        ]);

        $answer = $question->addAnswer([
            'user_id' => auth()->id(),
            'content' => request('content')
        ]);

        return back();
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return back();
    }
}
