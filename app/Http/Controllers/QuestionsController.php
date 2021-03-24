<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index()
    {

    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }
}
