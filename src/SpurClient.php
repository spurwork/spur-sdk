<?php

namespace Spur;

class SpurClient extends SpurClientBase
{

    // Billing

    public function addPaymentMethod(int $place_id, array $params)
    {
        return $this->post("places/{$place_id}/billing/payment-methods/credit", $params);
    }

    // Disputes

    public function getDispute(int $dispute_id)
    {
        return $this->get("disputes/{$dispute_id}");
    }

    public function createDispute(int $shift_id, array $params)
    {
        return $this->post("shifts/{$shift_id}/disputes", $params);
    }

    public function resolveDispute(int $dispute_id)
    {
        return $this->post("disputes/{$dispute_id}/resolve");
    }

    // Jobs

    public function createJob(int $place_id, array $params)
    {
        return $this->post("places/{$place_id}/jobs", $params);
    }

    // Job Invites

    public function getJobInvites(int $job_id, array $params)
    {
        return $this->get("jobs/{$job_id}/job-invites", $params);
    }

    public function createJobInvite(int $job_id, array $params)
    {
        return $this->post("jobs/{$job_id}/job-invites", $params);
    }

    public function deleteJobInvite(int $job_invite_id)
    {
        return $this->delete("job-invites/{$job_invite_id}");
    }

    // Job Requests

    public function getJobRequests(int $job_id, array $params)
    {
        return $this->get("jobs/{$job_id}/job-requests", $params);
    }

    // Places

    public function createPlace(array $params)
    {
        return $this->post('places/register', $params);
    }

    // Positions

    public function getPositions(array $params = [])
    {
        return $this->get("positions", $params);
    }

    // Punches

    public function getPunches(int $shift_id)
    {
        return $this->get("shifts/{$shift_id}/punches");
    }

    // Ratings

    public function createRating(int $worker_id, int $shift_id, array $params)
    {
        return $this->post("workers/{$worker_id}/rate/{$shift_id}", $params);
    }

    // Shifts

    public function cancelShifts(int $shift_id, array $params)
    {
        return $this->post("shifts/{$shift_id}/cancel", $params);
    }

    public function createShifts(int $team_id, array $params)
    {
        return $this->post("jobs/{$team_id}/shifts", $params);
    }

    // Workers

    public function blockWorker(int $place_id, array $params)
    {
        return $this->get("places/{$place_id}/block-worker", $params);
    }

    public function getWorker(int $worker_id, array $params = [])
    {
        return $this->get("workers/{$worker_id}", $params);
    }

    public function getWorkerCredentials(int $worker_id, array $params = [])
    {
        return $this->get("workers/{$worker_id}/credentials", $params);
    }

    public function getWorkers(int $team_id, array $params)
    {
        return $this->get("jobs/{$team_id}/workers", $params);
    }
}
