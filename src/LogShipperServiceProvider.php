<?php

namespace Asxcode\LogShipper;

use Illuminate\Support\ServiceProvider;

class LogShipperServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/log-shipper.php' => config_path('log-shipper.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('log-shipper', function () {
            return new LSLog();
        });
    }
}
