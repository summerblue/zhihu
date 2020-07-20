<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Question;
use App\Observers\QuestionObserver;
use App\Translator\BaiduSlugTranslator;
use App\Translator\Translator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Translator::class, BaiduSlugTranslator::class);
    }

    public function boot()
    {
        Question::observe(QuestionObserver::class);

        \View::composer('*',function ($view){
            $view->with('categories', Category::all());
        });

        if (config('app.debug')) {
            $this->app->register('VIACreative\SudoSu\ServiceProvider');
        }
    }
}
