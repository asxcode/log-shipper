<?php
namespace Asxcode\LogShipper;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class LogShipperLogger extends MonologLogger
{
    public function __construct($name, $handlers = [], $processors = [])
    {
        $handlers = [
            new StreamHandler($this->getLogFilePath('info'), self::INFO),
            new StreamHandler($this->getLogFilePath('error'), self::ERROR),
            new StreamHandler($this->getLogFilePath('warning'), self::WARNING),
            new StreamHandler($this->getLogFilePath('debug'), self::DEBUG),
            new StreamHandler($this->getLogFilePath('emergency'), self::EMERGENCY),
        ];

        parent::__construct($name, $handlers, $processors);
    }

    protected function getLogFilePath($logType)
    {
        $todayDate = now()->format('Y-m-d');
        $logDirectory = storage_path("logs/log-shipper/{$todayDate}");

        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        return $logDirectory . "/{$logType}.log";
    }
}