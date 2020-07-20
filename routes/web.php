<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/questions/{category?}', 'QuestionsController@index')->name('questions.index');
Route::get('/questions/create', 'QuestionsController@create')->name('questions.create');
Route::post('/questions', 'QuestionsController@store')->name('questions.store');
Route::get('/questions/{category}/{question}/{slug?}', 'QuestionsController@show')->name('questions.show');;

Route::post('/questions/{question}/subscriptions', 'SubscribeQuestionsController@store')->name('subscribe-questions.store');
Route::delete('/questions/{question}/subscriptions', 'SubscribeQuestionsController@destroy')->name('subscribe-questions.destroy');

Route::post('/questions/{question}/answers','AnswersController@store');

Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');

Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');

Route::post('/answers/{answer}/up-votes', 'AnswerUpVotesController@store')->name('answer-up-votes.store');
Route::delete('/answers/{answer}/up-votes', 'AnswerUpVotesController@destroy')->name('answer-up-votes.destroy');
Route::post('/answers/{answer}/down-votes', 'AnswerDownVotesController@store')->name('answer-down-votes.store');
Route::delete('/answers/{answer}/down-votes', 'AnswerDownVotesController@destroy')->name('answer-down-votes.destroy');

Route::post('/questions/{question}/up-votes', 'QuestionUpVotesController@store')->name('question-up-votes.store');
Route::delete('/questions/{question}/up-votes', 'QuestionUpVotesController@destroy')->name('question-up-votes.destroy');
Route::post('/questions/{question}/down-votes', 'QuestionDownVotesController@store')->name('question-down-votes.store');
Route::delete('/questions/{question}/down-votes', 'QuestionDownVotesController@destroy')->name('question-down-votes.destroy');

Route::post('/comments/{comment}/up-votes', 'CommentUpVotesController@store')->name('comment-up-votes.store');
Route::delete('/comments/{comment}/up-votes', 'CommentUpVotesController@destroy')->name('comment-up-votes.destroy');
Route::post('/comments/{comment}/down-votes', 'CommentDownVotesController@store')->name('comment-down-votes.store');
Route::delete('/comments/{comment}/down-votes', 'CommentDownVotesController@destroy')->name('comment-down-votes.destroy');

Route::post('/questions/{question}/published-questions', 'PublishedQuestionsController@store')->name('published-questions.store');

Route::get('/drafts', 'DraftsController@index');

Route::post('/questions/{question}/comments', 'QuestionCommentsController@store')->name('question-comments.store');

Route::post('/answers/{answer}/comments', 'AnswerCommentsController@store')->name('answer-comments.store');
