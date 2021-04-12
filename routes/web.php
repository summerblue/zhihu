<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/questions', 'QuestionsController@index');
Route::post('/questions', 'QuestionsController@store')->name('questions.store');
Route::get('/questions/{question}', 'QuestionsController@show');

Route::post('/questions/{question}/answers', 'AnswersController@store');

Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');
Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');
Route::post('/answers/{answer}/up-votes', 'AnswerUpVotesController@store')->name('answer-up-votes.store');
Route::delete('/answers/{answer}/up-votes', 'AnswerUpVotesController@destroy')->name('answer-up-votes.destroy');
Route::post('/answers/{answer}/down-votes', 'AnswerDownVotesController@store')->name('answer-down-votes.store');
Route::delete('/answers/{answer}/down-votes', 'AnswerDownVotesController@destroy')->name('answer-down-votes.destroy');
