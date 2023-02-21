<?php

namespace App\Repositories;

use App\Interfaces\ClientRepositoryInterface;
use App\Models\Client;
use App\Models\JobRequest;
use App\Models\Supervisor;

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
        $supervisor = Supervisor::where('client_id',$clientId)->pluck('id')->toArray();
        JobRequest::whereIn('supervisor_id',$supervisor)->delete();
        Client::destroy($clientId);
    }

    public function createClient(array $clientDetails) 
    {
        $client =  Client::create([
            "client_name" => $clientDetails['client_name'],
            "client_address" => $clientDetails['client_address'],
        ]);
        foreach($clientDetails['supervisor'] as $k => $value){
            Supervisor::create([
                'client_id' => $client->id,
                'supervisor' => $value,
                'address' => $clientDetails['supervisor_address'][$k]
            ]);
        }
        return $client;
    }

    public function updateClient($clientId, array $newDetails) 
    {
        $client = Client::where('id',$clientId)->update([
            "client_name" => $newDetails['client_name'],
            "client_address" => $newDetails['client_address'],
        ]);
        $client = Client::find($clientId);
        $update_id = array_keys($newDetails['supervisor']);
        Supervisor::where('client_id',$client->id)->whereNotIn("id",$update_id)->delete();
        foreach($newDetails['supervisor'] as $k => $value){
            $Supervisor = Supervisor::where("id",$k)->first();
            if($Supervisor){
                Supervisor::where('id',$k)->update([
                    'client_id' => $client->id,
                    'supervisor' => $value,
                    'address' => $newDetails['supervisor_address'][$k]
                ]);
            }else{
                Supervisor::create([
                    'client_id' => $client->id,
                    'supervisor' => $value,
                    'address' => $newDetails['supervisor_address'][$k]
                ]);
            }
        }

        return $client;
    }

    public function getFulfilledClients() 
    {
        return Client::where('is_fulfilled', true);
    }
}
