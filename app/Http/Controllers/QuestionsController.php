<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use App\Filters\QuestionFilter;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show','index']);

        $this->middleware('must-verify-email')->except(['index', 'show']);
    }

    public function index(Category $category, QuestionFilter $filters)
    {
        if ($category->exists) {
            $questions = Question::published()->where('category_id', $category->id);
        } else {
            $questions = Question::published();
        }

        $questions = $questions->filter($filters)->paginate(20);

        return view('questions.index', [
           'questions' => $questions
        ]);
    }

    public function show($questionId)
    {
        $question = Question::published()->findOrFail($questionId);

        $answers = $question->answers()->paginate(20);

        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $answers->items());

        return view('questions.show', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $question = Question::create([
            'user_id' => auth()->id(),
            'category_id' => request('category_id'),
            'title' => request('title'),
            'content' => request('content'),
        ]);

        return redirect("/drafts")->with('flash', '保存成功！');
    }

    public function create(Question $question)
    {
        $categories = Category::all();

        return view('questions.create', [
            'question' => $question,
            'categories' => $categories
        ]);
    }
}
