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

        // Automatically add the new channel to Laravel's logging configuration
        $this->addLoggingChannel();
    }

    public function register()
    {
        $this->app->bind('log-shipper', function () {
            return new LogShipperLogger();
        });
    }

    /**
     * Add the new logging channel to Laravel's logging configuration.
     *
     * @return void
     */
    protected function addLoggingChannel()
    {
        // Get the existing channels from the Laravel configuration
        $channels = config('logging.channels', []);

        // Add the new channel if it doesn't exist
        if (!isset($channels['log-shipper'])) {
            $channels['log-shipper'] = [
                'driver' => 'daily',
                'path' => storage_path('logs/log-shipper.log'),
                'level' => 'debug',
                'days' => 14,
            ];
        }

        // Update the modified configuration back to Laravel's config
        config(['logging.channels' => $channels]);
    }
}
