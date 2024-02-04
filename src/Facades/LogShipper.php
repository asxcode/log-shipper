<?php
namespace Asxcode\LogShipper\Facades;

use Illuminate\Support\Facades\Facade;

class LogShipper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'log-shipper';
    }
}
