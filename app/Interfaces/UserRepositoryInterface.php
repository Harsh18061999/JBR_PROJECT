<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUser();
    public function getUserId($orderId);
    public function deleteUser($orderId);
    public function createUser(array $orderDetails);
    public function updateUser($orderId, array $newDetails);
    public function getFulfilledUsers();
}
