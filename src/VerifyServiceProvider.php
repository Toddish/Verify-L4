<?php

namespace Toddish\Verify;

die('END');

use Illuminate\Support\ServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Auth\Guard;

class VerifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/verify.php' => config_path('verify.php')
        ], 'config');

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