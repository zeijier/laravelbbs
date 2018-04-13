<?php

namespace App\Providers;

use App\Models\Reply;
use App\Models\Topic;
use App\Observers\TopicObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        设置carbon 的中文时间提示
        \Carbon\Carbon::setLocale('zh');
        Topic::observe(TopicObserver::class);
//        Reply::observe(Reply::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment() == 'local' || app()->environment() == 'testing') {

            $this->app->register(\Summerblue\Generator\GeneratorsServiceProvider::class);

        }
    }
}
