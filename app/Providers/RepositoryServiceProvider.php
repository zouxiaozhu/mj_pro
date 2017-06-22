<?php

namespace App\Providers;

use App\Repository\Middleware\AuthPrms;
use App\Repository\Middleware\MiddlewareInterface\AuthPrmsInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("App\Repository\MjInterface\AuthInterface",'App\Repository\MJ\Auth\Auth');
        $this->app->bind("App\Repository\MjInterface\RoleInterface",'App\Repository\MJ\Auth\Role');
        $this->app->bind(AuthPrmsInterface::class,AuthPrms::class);
    }
}
