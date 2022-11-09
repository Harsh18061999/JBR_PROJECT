<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\JobRequesttRepsitory;
use App\DataTables\JobRequestDataTable;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\JobCategory;
use App\Models\JobRequest;
class JobRequestController extends Controller
{
    private JobRequesttRepsitory $jobRequestRepository;

    public function __construct(JobRequesttRepsitory $jobRequestRepository) 
    {
        $this->jobRequestRepository = $jobRequestRepository;
    }

    public function index(JobRequestDataTable $dataTable){
        $jobCategory = JobCategory::get();
        $client = Client::get();
        return $dataTable->render('content.jobRequest.index',compact('jobCategory','client'));
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        $client = Client::selectRaw("DISTINCT UPPER(client_name) as client_name")->get();
        return view('content.jobRequest.create',compact('jobCategory','client'));
    }

    public function get_supervisor(Request $request){
        $supervisor = Client::where('client_name',$request->client_name)->get()->toArray();
        return response()->json([
            "success" => true,
            "supervisor" => $supervisor
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'client_id' => 'required',
            'job_id' => 'required',
            'job_date' => 'required',
            'no_of_employee' => 'required'
        ]);
    
        $orderDetails = $request->only([
            'client_id',
            'job_id',
            'job_date',
            'no_of_employee'
        ]);

        $job_request = $this->jobRequestRepository->createJobRequest($orderDetails);

        return redirect()->route('job_request.index')
        ->with('success', 'Job Request Added Successfully.');
    }

    public function edit(JobRequest $job_request)
    {
        $jobCategory = JobCategory::get();
        $client = Client::selectRaw("DISTINCT UPPER(client_name) as client_name")->get();
        $client_selected = Client::where('id',$job_request->client_id)->first();
        $supervisor = Client::where('client_name',$client_selected->client_name)->get();
        
        return view('content.jobRequest.edit', compact('job_request','jobCategory','client_selected','client','supervisor'));
    }

    public function update(Request $request)
    {
        $job_request_id = $request->route('id');
        $request->validate([
            'client_id' => 'required',
            'job_id' => 'required',
            'job_date' => 'required',
            'no_of_employee' => 'required'
        ]);
    
        $orderDetails = $request->only([
            'client_id',
            'job_id',
            'job_date',
            'no_of_employee'
        ]);

        $this->jobRequestRepository->updateJobRequest($job_request_id,$orderDetails);

        return redirect()->route('job_request.index')
            ->with('success', 'Job Request updated successfully');
    }

    public function destory($id){
        $jobRequest = JobRequest::findOrFail($id);

        $this->jobRequestRepository->deleteJobRequest($id);

        return true;
    }
}
