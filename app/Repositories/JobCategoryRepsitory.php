<?php

namespace App\Repositories;

use App\Interfaces\JobCategoryRepositoryInterface;
use App\Models\JobCategory;

class JobCategoryRepsitory implements JobCategoryRepositoryInterface 
{
    public function getAllJobCategory() 
    {
        return JobCategory::all();
    }

    public function getJobCategoryId($jobCategoryId) 
    {
        return JobCategory::findOrFail($jobCategoryId);
    }

    public function deleteJobCategory($jobCategoryId) 
    {
        // Employee::where('job',$jobCategoryId)->update([
        //     'job' => 
        // ])
        JobCategory::destroy($jobCategoryId);
    }

    public function createJobCategory(array $jobCategoryDetails) 
    {
        return JobCategory::create($jobCategoryDetails);
    }

    public function updateJobCategory($jobCategoryId, array $newDetails) 
    {
        return JobCategory::whereId($jobCategoryId)->update($newDetails);
    }

    public function getFulfilledJobCategorys() 
    {
        return JobCategory::where('is_fulfilled', true);
    }
}
