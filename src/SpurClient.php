<?php

namespace Spur;

class SpurClient extends SpurClientBase
{
    // Jobs

    public function createJob(int $place_id, array $params)
    {
        return $this->post("places/{$place_id}/jobs", $params);
    }

    // Places

    public function createPlace(array $params)
    {
        return $this->post('places/register', $params);
    }

    // Positions

    public function getPositions(array $queryParams = [])
    {
        return $this->get("positions", $queryParams);
    }

    // Punches

    public function getPunches(int $shift_id)
    {
        return $this->get("shifts/{$shift_id}/punches");
    }
}
