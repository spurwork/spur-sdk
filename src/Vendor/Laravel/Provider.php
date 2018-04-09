<?php

namespace Spur\Vendor\Laravel;

use Spur\SpurClient;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpurClient::class, function ($app) {
            return new SpurClient(
                config('services.spur.url'),
                config('services.spur.secret')
            );
        });
    }
}
