<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\ClientRepsitory;
use App\DataTables\ClientDataTable;
use App\Models\Client;
use App\Models\Supervisor;
use App\Models\City;
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
        return $dataTable->render('content.client.index', compact('jobCategory', 'client'));
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        $city = City::get();
        return view('content.client.create', compact('jobCategory', 'city'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'client_name' => 'required|unique:clients,client_name',
            'supervisor' => 'required',
            'client_address' => 'required',
            // 'job' => 'required'
        ]);

        $client = $this->clientRepository->createClient($request->all());

        return redirect()
            ->route('client.index')
            ->with('success', 'Record created successfully.');
    }

    public function edit(Client $client)
    {
        $supervisors = Supervisor::where('client_id', $client->id)
            ->get()
            ->toArray();
        $last_id = max(array_column($supervisors, 'id'));
        $city = City::get();
        // dd($supervisors);
        return view('content.client.edit', compact('client', 'supervisors', 'last_id','city'));
    }

    public function update(Request $request)
    {
        $clientId = $request->route('id');
        $client = Client::findOrFail($clientId);
     
        $request->validate([
            'client_name' => 'required',
            'supervisor' => 'required',
            'client_address' => 'required',
        ]);

        $orderDetails = $request->only(['client_name', 'supervisor', 'client_address', 'supervisor_address','city_id']);

        $this->clientRepository->updateClient($clientId, $orderDetails);

        return redirect()
            ->route('client.index')
            ->with('success', 'Client updated successfully');
    }

    public function destory($id)
    {
        $this->clientRepository->deleteClient($id);

        return true;
    }

    public function block($id)
    {
        $client = Client::where('id', $id)->first();
        if ($client) {
            $client->update([
                'status' => '2',
            ]);
            $response['success'] = true;
            $response['message'] = 'Client Has Been Blocked.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';
        }
        return $response;
    }

    public function unBlock($id)
    {
        $client = Client::where('id', $id)->first();
        if ($client) {
            $client->update([
                'status' => '0',
            ]);
            $response['success'] = true;
            $response['message'] = 'Client has been nnBlocked.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';
        }
        return $response;
    }

    public function addMore(Request $request)
    {
        $city = City::get();
        $option = '';
        foreach ($city as $value) {
            $option .= "<option value='$value->id'>$value->city_title</option>";
        }
        $id = $request->key;
        $div = "<div class='row m-0 p-0 mt-2' id='delete$id'>
                    <div class='col-md-5 form-floating error_message'>
                        <input type='text' name='supervisor[$id]' class='form-control'
                            id='supervisor' placeholder='John' aria-describedby='floatingInputHelp'
                            data-error='errNm1' />
                        <label for='supervisor' style='padding-left: 24px;'>Supervisor<span class='text-danger'>*</span></label>
                    </div>
                    <div class='col-md-7 form-group '>
                        <div class='form-floating'>
                            <textarea class='form-control' name='supervisor_address[$id]' id='supervisor_address' rows='5' cols='5'></textarea>
                            <label for='floatingInput'>Supervisor Address<span class='text-danger'>*</span></label>
                        </div>
                    </div>
                    <div class='col-md-5'>
                        <div class='mt-2'>
                          
                            <div class='form-floating'>
                                <select name='city_id[$id]' class='form-select'>
                                    <option value=''>Please select Provience</option>
                                    $option
                                </select>
                                <label for='Provience'>Provience <span class='text-danger'>*</span></label>
                            </div>
                           
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='mt-4 btn btn-sm less btn-danger mt-3 mx-2' data-id='$id'>
                            <i class='fa-solid fa-minus'></i>
                        </div>
                    </div>
                </div>";

        $response['success'] = true;
        $response['div'] = $div;
        return $response;
    }
}
