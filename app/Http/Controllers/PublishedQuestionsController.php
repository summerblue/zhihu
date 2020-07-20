<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    }
}
