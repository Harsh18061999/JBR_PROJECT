<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ClientRepsitory;
use App\DataTables\ClientDataTable;
use App\Models\Client;
use App\Models\JobCategory;

class ClientController extends Controller
{
    private ClientRepsitory $clientRepository;

    public function __construct(ClientRepsitory $clientRepository) 
    {
        $this->clientRepository = $clientRepository;
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        return view('content.user.client.create',compact('jobCategory'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'client_name' => 'required',
            'supervisor' => 'required',
            'client_address' => 'required',
            'job' => 'required'
        ]);

        $client = $this->clientRepository->createClient($request->all());

        return redirect()->back()->with('success', 'Thank you for your application. We will get back to you soon.');
    }
}
