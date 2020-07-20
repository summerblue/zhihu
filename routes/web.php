<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/questions', 'QuestionsController@index');
Route::get('/questions/{question}', 'QuestionsController@show');

Route::post('/questions/{question}/answers','AnswersController@store');
