<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Question;
use App\Observers\QuestionObserver;
use App\Translator\BaiduSlugTranslator;
use App\Translator\Translator;
use App\Models\Category;

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

        \View::composer('*',function ($view){
            $view->with('categories', Category::all());
        });
    }
}
