<?php

namespace App\Repositories;

use App\Interfaces\ProvinceRepositoryInterface;
use App\Models\Provience;
class ProvinceRepository implements ProvinceRepositoryInterface 
{
    public function getAllProvince() 
    {   
        return Provience::all();
    }

    public function getProvinceId($provinceId) 
    {
        return Provience::findOrFail($provinceId);
    }

    public function deleteProvince($provinceId) 
    {
        Provience::destroy($provinceId);
    }

    public function createProvince(array $provinceDetails) 
    {
        return Provience::create($provinceDetails);
    }

    public function updateProvince($provinceId, array $newDetails) 
    {
        return Provience::whereId($provinceId)->update($newDetails);
    }

    public function getFulfilledprovinces() 
    {
        return Provience::where('is_fulfilled', true);
    }
}
