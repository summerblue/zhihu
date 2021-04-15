<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Translator\BaiduSlugTranslator;
use App\Translator\Translator;
use App\Models\Category;
use App\Models\Question;
use App\Observers\QuestionObserver;
use App\Models\Answer;
use App\Observers\AnswerObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug')) {
            $this->app->register('VIACreative\SudoSu\ServiceProvider');
        }

        $this->app->bind(Translator::class, BaiduSlugTranslator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Question::observe(QuestionObserver::class);
        Answer::observe(AnswerObserver::class);

        \View::composer('*',function ($view){
            $view->with('categories', Category::all());
        });
    }
}
