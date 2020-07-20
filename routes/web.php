<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/questions', 'QuestionsController@index');
Route::get('/questions/{question}', 'QuestionsController@show');

Route::post('/questions/{question}/answers','AnswersController@store');

Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');

Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');
