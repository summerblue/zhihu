<?php

namespace App\Providers;

use App\Policies\QuestionPolicy;
use App\Question;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Question::class => QuestionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
