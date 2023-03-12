<?php

namespace App\Interfaces;

interface CityRepositoryInterface
{
    public function getAllCity();
    public function getCityId($orderId);
    public function deleteCity($orderId);
    public function createCity(array $orderDetails);
    public function updateCity($orderId, array $newDetails);
    public function getFulfilledcities();   
}
