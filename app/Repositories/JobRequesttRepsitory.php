<?php

namespace App\Repositories;

use App\Interfaces\JobRequestRepositoryInterface;
use App\Models\JobRequest;

class JobRequesttRepsitory implements JobRequestRepositoryInterface 
{
    public function getAllJobRequest() 
    {
        return JobRequest::all();
    }

    public function getJobRequestId($jobRequestId) 
    {
        return JobRequest::findOrFail($jobRequestId);
    }

    public function deleteJobRequest($jobRequestId) 
    {
        JobRequest::destroy($jobRequestId);
    }

    public function createJobRequest(array $jobRequestDetails) 
    {
        return JobRequest::create($jobRequestDetails);
    }

    public function updateJobRequest($jobRequestId, array $newDetails) 
    {
        return JobRequest::whereId($jobRequestId)->update($newDetails);
    }

    public function getFulfilledJobRequests() 
    {
        return JobRequest::where('is_fulfilled', true);
    }
}
