<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\BlogPost;
use App\User;

class ActivityComposer 
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('blog-post-most-commented', now()->addHour(), function() {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $activeUsers = Cache::remember('user-most-active', now()->addHour(), function() {
            return User::mostActive()->take(3)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('activeUsers', $activeUsers);
    }
}