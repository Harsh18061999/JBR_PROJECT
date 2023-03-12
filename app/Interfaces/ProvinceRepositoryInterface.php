<?php

namespace App\Interfaces;

interface ProvinceRepositoryInterface 
{
    public function getAllProvince();
    public function getProvinceId($orderId);
    public function deleteProvince($orderId);
    public function createProvince(array $orderDetails);
    public function updateProvince($orderId, array $newDetails);
    public function getFulfilledprovinces();
}
