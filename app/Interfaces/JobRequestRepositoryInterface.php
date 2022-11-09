<?php

namespace App\Interfaces;

interface JobRequestRepositoryInterface 
{
    public function getAllJobRequest();
    public function getJobRequestId($orderId);
    public function deleteJobRequest($orderId);
    public function createJobRequest(array $orderDetails);
    public function updateJobRequest($orderId, array $newDetails);
    public function getFulfilledJobRequests();
}
