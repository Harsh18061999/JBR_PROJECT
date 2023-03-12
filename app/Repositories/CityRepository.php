<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;

class CityRepository implements CityRepositoryInterface 
{
    public function getAllCity() 
    {   
        return City::all();
    }

    public function getCityId($cityId) 
    {
        return City::findOrFail($cityId);
    }

    public function deleteCity($cityId) 
    {
        City::destroy($cityId);
    }

    public function createcity(array $cityDetails) 
    {
        return City::create($cityDetails);
    }

    public function updateCity($citiesId, array $newDetails) 
    {
        return City::whereId($citiesId)->update($newDetails);
    }

    public function getFulfilledcities() 
    {
        return City::where('is_fulfilled', true);
    }
}
