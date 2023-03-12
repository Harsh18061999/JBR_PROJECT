<?php

namespace App\Interfaces;

interface CountryRepositoryInterface 
{
    public function getAllCountry();
    public function getCountryId($orderId);
    public function deleteCountry($orderId);
    public function createCountry(array $orderDetails);
    public function updateCountry($orderId, array $newDetails);
    public function getFulfilledcountries();
}
