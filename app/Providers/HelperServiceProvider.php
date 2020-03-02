<?php

namespace App\Providers;

use App\IpProviders\IpProvider;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $file = app_path('Helper.php');
        if (file_exists($file)) {
            require_once($file);
        }

        $this->app->singleton('App\IpProviders\IpProvider', function ($app) {
            $path = 'App\IpProviders\\' . ucfirst(env('IP_URL_PROVIDER'));
            return new $path();
        });
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
