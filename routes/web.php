<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/questions/{category?}', 'QuestionsController@index')->name('questions.index');
Route::get('/questions/create', 'QuestionsController@create')->name('questions.create');
Route::post('/questions', 'QuestionsController@store')->name('questions.store');
Route::get('/questions/{question}', 'QuestionsController@show');
Route::post('/questions/{question}/published-questions', 'PublishedQuestionsController@store')->name('published-questions.store');

Route::post('/questions/{question}/answers', 'AnswersController@store');

Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');
Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');
Route::post('/answers/{answer}/up-votes', 'AnswerUpVotesController@store')->name('answer-up-votes.store');
Route::delete('/answers/{answer}/up-votes', 'AnswerUpVotesController@destroy')->name('answer-up-votes.destroy');
Route::post('/answers/{answer}/down-votes', 'AnswerDownVotesController@store')->name('answer-down-votes.store');
Route::delete('/answers/{answer}/down-votes', 'AnswerDownVotesController@destroy')->name('answer-down-votes.destroy');

Route::get('/drafts', 'DraftsController@index');
