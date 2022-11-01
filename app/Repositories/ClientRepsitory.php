<?php

namespace App\Repositories;

use App\Interfaces\ClientRepositoryInterface;
use App\Models\Client;

class ClientRepsitory implements ClientRepositoryInterface 
{
    public function getAllClient() 
    {
        return Client::all();
    }

    public function getClientId($clientId) 
    {
        return Client::findOrFail($cientId);
    }

    public function deleteClient($clientId) 
    {
        Client::destroy($clientId);
    }

    public function createClient(array $clientDetails) 
    {
        return Client::create($clientDetails);
    }

    public function updateClient($clientId, array $newDetails) 
    {
        return Client::whereId($clientId)->update($newDetails);
    }

    public function getFulfilledClients() 
    {
        return Client::where('is_fulfilled', true);
    }
}
