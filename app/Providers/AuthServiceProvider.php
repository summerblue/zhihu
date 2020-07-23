<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use App\Models\Question;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
