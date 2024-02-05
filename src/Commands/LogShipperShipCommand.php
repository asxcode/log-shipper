<?php

namespace Asxcode\LogShipper\Commands;

use Illuminate\Console\Command;

class LogShipperShipCommand extends Command
{
    protected $signature = 'log-shipper:ship';
    protected $description = 'Ship logs to a remote server.';

    public function handle()
    {
        // log shipping logic goes here
        
        $this->info('Logs have been shipped!');
    }
}
