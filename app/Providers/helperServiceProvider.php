<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class helperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        // $this->app->singleton('helpers', function ($app) {
        //     return require app_path('Helpers/date_function.php');
        //   });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
