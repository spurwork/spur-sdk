<?php

namespace Spur;

class SpurClient extends SpurClientBase
{
    public function createPlace(array $params)
    {
        return $this->post('places/register', $params);
    }
}
