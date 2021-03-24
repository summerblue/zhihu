<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function store($questionId)
    {
        $question = Question::published()->findOrFail($questionId);

        $question->answers()->create([
            'user_id' => request('user_id'),
            'content' => request('content')
        ]);

        return response()->json([],201);
    }
}
