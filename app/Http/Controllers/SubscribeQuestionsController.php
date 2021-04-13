<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class SubscribeQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->subscriptions()->create([
            'user_id' => auth()->id()
        ]);

        return response([], 201);
    }

    public function destroy(Question $question)
    {
        $question->subscriptions()
            ->where('user_id', auth()->id())
            ->delete();

        return response([], 201);
    }
}
