<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Notifications\YouWereInvited;
use App\Models\User;
use App\Events\PublishQuestion;

class PublishedQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $this->authorize('update', $question);

        $question->publish();

        event(new PublishQuestion($question));

		return redirect("/questions/{$question->id}")->with('flash', "发布成功！");
    }
}
