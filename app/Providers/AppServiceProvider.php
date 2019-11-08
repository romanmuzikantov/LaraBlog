<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.card', 'card');
        Blade::component('components.tags', 'tags');
        Blade::component('components.comment', 'comment');
        Blade::component('components.errors', 'errors');
        
        view()->composer(['post.index', 'post.show'], ActivityComposer::class);
        // view()->composer('post.show', ActivityComposer::class);
    }
}
