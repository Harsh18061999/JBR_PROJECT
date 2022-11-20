<?php

namespace App\Interfaces;

interface DataEntryRepositoryInterface 
{
    public function getAllDataEntry();
    public function getDataEntryId($orderId);
    public function deleteDataEntry($orderId);
    public function createDataEntry(array $orderDetails);
    public function updateDataEntry($orderId, array $newDetails);
    public function getFulfilledDataEntrys();
}
