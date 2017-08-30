<?php

namespace Jcc\Taxi;

use Illuminate\Support\ServiceProvider;

class TaxiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('taxi', function () {
            return new Taxi;
        });
    }
}