<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class DraftsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $drafts = Question::drafts(auth()->id())->get();

        return view('drafts.index', [
            'drafts' => $drafts
        ]);
    }
}
