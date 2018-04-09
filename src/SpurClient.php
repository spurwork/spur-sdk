<?php

namespace Spur;

class SpurClient extends SpurClientBase
{
    public function createJob(int $place_id, array $params)
    {
        return $this->post("places/{$place_id}/jobs", $params);
    }

    public function createPlace(array $params)
    {
        return $this->post('places/register', $params);
    }
}
