<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Schema::defaultStringLength(191);
        Inertia::share('auth.user', function () {
            return Auth::user();
        });
        Inertia::share('errors', function () {
            return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) [];
        });
        Inertia::share('error', function () {
            return Session::get('error');
        });
        Inertia::share('success', function () {
            return Session::get('success');
        });
    }
}
