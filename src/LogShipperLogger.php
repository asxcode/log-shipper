<?php
namespace Asxcode\LogShipper;

use Monolog\Logger as MonologLogger;

class LogShipperLogger extends MonologLogger
{
    public function __construct($name, $handlers = [], $processors = [])
    {
        // Add custom log handlers for different log types
        $handlers = [
            new StreamHandler($this->getLogFilePath('info'), self::INFO),
            new StreamHandler($this->getLogFilePath('error'), self::ERROR),
            // Add more handlers for other log types as needed
        ];

        parent::__construct($name, $handlers, $processors);
    }

    protected function getLogFilePath($logType)
    {
        $todayDate = now()->format('Y-m-d');
        $logDirectory = storage_path("logs/log-shipper/{$logType}/{$todayDate}");

        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        return $logDirectory . "/{$logType}.log";
    }
}