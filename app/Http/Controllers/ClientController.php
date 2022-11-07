<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\ClientRepsitory;
use App\DataTables\ClientDataTable;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\JobCategory;

class ClientController extends Controller
{
    private ClientRepsitory $clientRepository;

    public function __construct(ClientRepsitory $clientRepository) 
    {
        $this->clientRepository = $clientRepository;
    }

    public function index(ClientDataTable $dataTable)
    {
        $jobCategory = JobCategory::get();
        $client = Client::get();
        return $dataTable->render('content.client.index',compact('jobCategory','client'));
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        return view('content.client.create',compact('jobCategory'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'client_name' => 'required',
            'supervisor' => 'required',
            'client_address' => 'required',
            // 'job' => 'required'
        ]);

        $client = $this->clientRepository->createClient($request->all());

        return redirect()->route('client.index')
        ->with('success', 'Record created successfully.');
    }

    public function edit(Client $client)
    {
        $jobCategory = JobCategory::get();
        
        return view('content.client.edit', compact('client','jobCategory'));
    }

    public function update(Request $request)
    {
        $clientId = $request->route('id');
        $client = Client::findOrFail($clientId);

        $request->validate([
            'client_name' => 'required',
            'supervisor' => 'required',
            'client_address' => 'required',
            // 'job' => 'required'
        ]);

        $orderDetails = $request->only([
            'client_name',
            'supervisor',
            'client_address',
            // 'job'
        ]);

        $this->clientRepository->updateClient($clientId,$orderDetails);

        return redirect()->route('client.index')
            ->with('success', 'Client updated successfully');
    }

    public function destory($id){

        $this->clientRepository->deleteClient($id);

        return true;
    }

    public function block($id){
        $client = Client::where('id',$id)->first();
        if($client){
            $client->update([
                'status' => '2'
            ]);
            $response['success'] = true;
            $response['message'] = 'Client Has Been Blocked.';  
        }else{
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';  

        }
        return $response;
    }

    public function unBlock($id){
        $client = Client::where('id',$id)->first();
        if($client){
            $client->update([
                'status' => '0'
            ]);
            $response['success'] = true;
            $response['message'] = 'Client Has Been UnBlocked.';  
        }else{
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';
        }
        return $response;
    }
}
