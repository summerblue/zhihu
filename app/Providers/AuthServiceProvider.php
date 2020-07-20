<?php

namespace App\Providers;

use App\Models\Answer;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use App\Models\Question;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
