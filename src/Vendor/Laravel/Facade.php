<?php

namespace Spur\Vendor\Laravel;

use Spur\SpurClient;
use Illuminate\Support\Facades\Facade;

class Spur extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SpurClient::class;
    }
}
