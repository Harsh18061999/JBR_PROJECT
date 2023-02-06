<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;

class EmployeerRepository implements EmployeeRepositoryInterface 
{
    public function getAllEmployee() 
    {
        return Employee::all();
    }

    public function getEmployeeId($employeeId) 
    {
        return Employee::findOrFail($employeeId);
    }

    public function deleteEmployee($employeeId) 
    {
        Employee::where('id',$employeeId)->forceDelete();
    }

    public function createEmployee(array $employeeDetails) 
    {
        $employeeDetails['lincense'] = $employeeDetails['filename'];
        unset($employeeDetails['filename']);
        $employee = Employee::withTrashed()->where('contact_number',$employeeDetails['contact_number'])->orWhere('email',$employeeDetails['email'])->first();
        if(!$employee){
            return Employee::create($employeeDetails);
        }else{
            return $employee->restore();
        }
    }

    public function updateEmployee($employeeId, array $newDetails) 
    {
        $newDetails['lincense'] = $newDetails['filename'];
        unset($newDetails['filename']);
        return Employee::whereId($employeeId)->update($newDetails);
    }

    public function getFulfilledEmployees() 
    {
        return Employee::where('is_fulfilled', true);
    }
}
