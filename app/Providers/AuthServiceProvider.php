<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicies'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-secret', function($user) {
            return $user->is_admin;
        });

        // Gate::resource('posts', 'App\Policies\BlogPostPolicies');

        // Gate::before(function ($user, $policy) {
        //     if($user->is_admin && in_array($policy, ['delete', 'update'])) {
        //         return true;
        //     }
        // });

        //
    }
}
