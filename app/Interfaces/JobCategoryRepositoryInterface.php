<?php

namespace App\Interfaces;

interface JobCategoryRepositoryInterface 
{
    public function getAllJobCategory();
    public function getJobCategoryId($orderId);
    public function deleteJobCategory($orderId);
    public function createJobCategory(array $orderDetails);
    public function updateJobCategory($orderId, array $newDetails);
    public function getFulfilledJobCategorys();
}
