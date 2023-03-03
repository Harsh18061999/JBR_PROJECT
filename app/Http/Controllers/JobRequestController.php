<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\JobRequesttRepsitory;
use App\DataTables\JobRequestDataTable;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\JobCategory;
use App\Models\JobConfirmation;
use App\Models\EmployeeTimeSheet;
use App\Models\JobRequest;
use App\Models\Supervisor;
use Http;
use App\Models\Employee;

class JobRequestController extends Controller
{
    private JobRequesttRepsitory $jobRequestRepository;

    public function __construct(JobRequesttRepsitory $jobRequestRepository) 
    {
        $this->jobRequestRepository = $jobRequestRepository;
    }

    public function index(JobRequestDataTable $dataTable){
        $role = auth()->user()->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $jobCategory = JobCategory::get();
        $client = Client::get();
        $supervisor = array();
        if($role_name != 'admin'){
            $supervisor = Supervisor::where('client_id',auth()->user()->client_id)->get();
        }
        return $dataTable->render('content.jobRequest.index',compact('jobCategory','client','supervisor','role_name'));
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        $client = Client::get();
        return view('content.jobRequest.create',compact('jobCategory','client'));
    }

    public function get_supervisor(Request $request){
        $supervisor = Supervisor::where('client_id',$request->client_id)->get()->toArray();
        return response()->json([
            "success" => true,
            "supervisor" => $supervisor
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'supervisor_id' => 'required',
            'job_id' => 'required',
            'job_date' => 'required',
            'end_date' => 'required',
            'hireperiod' => 'required',
            'start_hours' => 'required',
            'end_hours' => 'required',
            'start_minutes' => 'required',
            'end_minutes' => 'required',
            'start_day' => 'required',
            'end_day' => 'required',
            'no_of_employee' => 'required'
        ]);
    
        $orderDetails = $request->only([
            'supervisor_id',
            'job_id',
            'job_date',
            'end_date',
            'hireperiod',
            'no_of_employee'
        ]);

        $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;

        $job_request = $this->jobRequestRepository->createJobRequest($orderDetails);

        return redirect()->route('job_request.index')
        ->with('success', 'Job Request Added successfully.');
    }

    public function edit(JobRequest $job_request)
    {
        $start_time = explode(":",$job_request->start_time);
        $end_time = explode(":",$job_request->end_time);
        $jobCategory = JobCategory::get();
        $client = Client::get();
        $selected_supervisor = Supervisor::where('id',$job_request->supervisor_id)->first();
        $supervisor = Supervisor::where('client_id',$selected_supervisor->client_id)->get();
        
        return view('content.jobRequest.edit', compact('job_request','jobCategory','client','supervisor','selected_supervisor','start_time','end_time'));
    }

    public function update(Request $request)
    {
        $job_request_id = $request->route('id');
        $request->validate([
            'supervisor_id' => 'required',
            'job_id' => 'required',
            'job_date' => 'required',
            'end_date' => 'required',
            'hireperiod' => 'required',
            'start_hours' => 'required',
            'end_hours' => 'required',
            'start_minutes' => 'required',
            'end_minutes' => 'required',
            'start_day' => 'required',
            'end_day' => 'required',
            'no_of_employee' => 'required'
        ]);
    
        $orderDetails = $request->only([
            'supervisor_id',
            'job_id',
            'job_date',
            'end_date',
            'hireperiod',
            'no_of_employee'
        ]);

        $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;

        $this->jobRequestRepository->updateJobRequest($job_request_id,$orderDetails);

        return redirect()->route('job_request.index')
            ->with('success', 'Job Request updated successfully');
    }

    public function destory($id){
        $jobRequest = JobRequest::findOrFail($id);
        $jobConfirmation = JobConfirmation::where('job_id',$id)->pluck('id')->toArray();
        EmployeeTimeSheet::whereIn('job_confirmations_id',$jobConfirmation)->delete();
        JobConfirmation::whereIn('id',$jobConfirmation)->delete();
        $this->jobRequestRepository->deleteJobRequest($id);

        return true;
    }
}
