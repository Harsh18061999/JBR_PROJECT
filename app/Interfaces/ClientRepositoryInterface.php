<?php

namespace App\Interfaces;

interface ClientRepositoryInterface 
{
    public function getAllClient();
    public function getClientId($orderId);
    public function deleteClient($orderId);
    public function createClient(array $orderDetails);
    public function updateClient($orderId, array $newDetails);
    public function getFulfilledClients();
}
