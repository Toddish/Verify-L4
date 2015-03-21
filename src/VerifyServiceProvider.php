<?php

namespace Toddish\Verify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Auth\Guard;

class VerifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/verify.php' => config_path('verify.php')
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/verify.php', 'verify');

       $this->publishes([
           __DIR__.'/../database/migrations/' => base_path('database/migrations')
       ], 'migrations');

       $this->publishes([
           __DIR__.'/../database/seeds/' => base_path('database/seeds')
       ], 'seeds');

        // $this->publishes([
        //     realpath(__DIR__.'/path/to/migrations') => $this->app->databasePath().'/migrations',
        // ]);

        // \Auth::extend('verify', function()
        // {
        //     return new Guard(
        //         new VerifyUserProvider(
        //             new BcryptHasher,
        //             \Config::get('auth.model')
        //         ),
        //         \App::make('session.store')
        //     );
        // });
    }

    public function register()
    {

    }
}