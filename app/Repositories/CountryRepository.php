<?php

namespace App\Repositories;

use App\Interfaces\CountryRepositoryInterface;
use App\Models\Country;
class CountryRepository implements CountryRepositoryInterface 
{
    public function getAllCountry() 
    {   
        return Country::all();
    }

    public function getCountryId($countryId) 
    {
        return Country::findOrFail($countryId);
    }

    public function deleteCountry($countryId) 
    {
        Country::destroy($countryId);
    }

    public function createCountry(array $countryDetails) 
    {
        return Country::create($countryDetails);
    }

    public function updateCountry($countrieId, array $newDetails) 
    {
        return Country::whereId($countrieId)->update($newDetails);
    }

    public function getFulfilledcountries() 
    {
        return Country::where('is_fulfilled', true);
    }
}
