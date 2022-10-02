<?php

namespace App\Interfaces;

interface EmployeeRepositoryInterface 
{
    public function getAllEmployee();
    public function getEmployeeId($orderId);
    public function deleteEmployee($orderId);
    public function createEmployee(array $orderDetails);
    public function updateEmployee($orderId, array $newDetails);
    public function getFulfilledEmployees();
}
