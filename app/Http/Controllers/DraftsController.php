<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

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
