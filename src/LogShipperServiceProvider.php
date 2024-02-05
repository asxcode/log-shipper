<?php

namespace Asxcode\LogShipper;

use Illuminate\Support\ServiceProvider;
use Asxcode\LogShipper\Commands\LogShipperShipCommand;

class LogShipperServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LogShipperShipCommand::class,
            ]);
        }

        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/log-shipper.php' => config_path('log-shipper.php'),
        ], 'config');

        // Merge configuration file
        $this->mergeConfigFrom(
            __DIR__.'/../config/log-shipper.php', 'log-shipper'
        );
    }

    public function register()
    {
        $this->app->bind('log-shipper', function () {
            return new LogShipperLogger('log-shipper', [], []);
        });
    }
}
