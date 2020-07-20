<?php

use Illuminate\Support\Facades\Route;

Route::get('/questions', 'QuestionsController@index');
Route::get('/questions/{question}', 'QuestionsController@show');
