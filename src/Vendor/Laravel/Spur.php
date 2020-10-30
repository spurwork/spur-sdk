<?php

namespace Spur\Vendor\Laravel;

use Illuminate\Support\Facades\Facade;
use Spur\SpurClient;

class Spur extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SpurClient::class;
    }
}
