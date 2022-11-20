<?php

namespace App\Repositories;

use App\Interfaces\DataEntryRepositoryInterface;
use App\Models\EmployeeDataEntryPoint;

class DataEntryPointRepository implements DataEntryRepositoryInterface 
{
    public function getAllDataEntry() 
    {
        return EmployeeDataEntryPoint::all();
    }

    public function getDataEntryId($dataEntryId) 
    {
        return EmployeeDataEntryPoint::findOrFail($dataEntryId);
    }

    public function deleteDataEntry($dataEntryId) 
    {
        EmployeeDataEntryPoint::destroy($dataEntryId);
    }

    public function createDataEntry(array $dataEntryDetails) 
    {
        $dataEntryDetails['personal_identification'] = $dataEntryDetails['personal_identification_file'];
        unset($dataEntryDetails['personal_identification_file']);
        return EmployeeDataEntryPoint::create($dataEntryDetails);
    }

    public function updateDataEntry($dataEntryId, array $newDetails) 
    {
        $newDetails['personal_identification'] = $newDetails['personal_identification_file'];
        unset($newDetails['personal_identification_file']);
        return EmployeeDataEntryPoint::whereId($dataEntryId)->update($newDetails);
    }

    public function getFulfilledDataEntrys() 
    {
        return EmployeeDataEntryPoint::where('is_fulfilled', true);
    }
}
