<?php

namespace Zfile;

use Illuminate\Support\ServiceProvider;
use Zfile\Console\Get;

class ZMediaServiceProvider extends ServiceProvider
{
    protected $config = 'zmeida.php';
    protected $database = 'zmedia';
    
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/zhanglong.php' => config_path('zhanglong.php')
        ], 'config');
        $this->publishes([__DIR__ . '/../src/Databases/zmedia.php' => database_path('/migrations/zmdia.php')], 'migrations');
        $this->publishes([__DIR__ . '/../src/Databases/zmedia_seed.php' => database_path('/seeds/zmdia_seeds.php')],'seeds');
        $this->commands([
            Get::class
        ]);
    }
    
    public function register()
    {
        $this->app->singleton('zmeida', new ZMediaService());
    }
}