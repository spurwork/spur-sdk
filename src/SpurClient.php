<?php

namespace Spur;

class SpurClient extends SpurClientBase
{
    public function __construct($token, $timeout = 30)
    {
        parent::__construct($token, 'X-Spur-Server-Token', $timeout);
    }

    public function createDistrict()
    {
        // TODO
    }
}
