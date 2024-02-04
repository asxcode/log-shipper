<?php
namespace Asxcode\LogShipper;

use Illuminate\Support\Facades\Log;

class LogShipperLogger
{
    protected $logDirectory;

    public function __construct()
    {
        $this->logDirectory = config('log-shipper.log_directory', storage_path('logs/log-shipper'));
    }

    public function info($message, $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function warning($message, $context = [])
    {
        $this->log('warning', $message, $context);
    }

    public function error($message, $context = [])
    {
        $this->log('error', $message, $context);
    }

    protected function log($level, $message, $context = [])
    {
        $logDirectory = $this->createLogDirectory();
        Log::useFiles($logDirectory.'/log-shipper.log');
        Log::$level($message, $context);
    }

    protected function createLogDirectory()
    {
        $todayDirectory = now()->format('Y-m-d');
        $logDirectory = $this->logDirectory.'/'.$todayDirectory;

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        return $logDirectory;
    }
}
