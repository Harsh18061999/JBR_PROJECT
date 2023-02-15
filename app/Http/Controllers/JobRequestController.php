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
            'client_id',
            'job_id',
            'job_date',
            'end_date',
            'hireperiod',
            'no_of_employee'
        ]);

        $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;

        $job_request = $this->jobRequestRepository->createJobRequest($orderDetails);

        $job_request = JobRequest::where('job_message_status','0')->first();
        // if($job_request){
        //     $employee = Employee::where('status','0')->limit(3)->get();
        //     foreach($employee as $k => $value){
        //         $client = Client::where('id',$job_request->client_id)->first();
        //         $job = JobCategory::where('id',$job_request->job_id)->first();
        //         $curl = curl_init();
        //         $curl1 = curl_init();

        //         $message = $client->client_name.' has been required to work for '.$job->job_title.' '.$client->supervisor;
        //         $number =  $value->contact_number;

        //         $message .= "\n Please select below link to fill the form \n".route('front.job_request');
        //         $link = route('front.job_request');
                
        //         curl_setopt_array($curl, array(
        //             CURLOPT_URL => "https://api.ultramsg.com/instance22910/messages/chat",
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_ENCODING => "",
        //             CURLOPT_MAXREDIRS => 10,
        //             CURLOPT_TIMEOUT => 30,
        //             CURLOPT_SSL_VERIFYHOST => 0,
        //             CURLOPT_SSL_VERIFYPEER => 0,
        //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //             CURLOPT_CUSTOMREQUEST => "POST",
        //             CURLOPT_POSTFIELDS => "token=7iqilksxb8xyctsv&to=$number&body=$message&priority=10&referenceId=",
        //             CURLOPT_HTTPHEADER => array(
        //                 "content-type: application/x-www-form-urlencoded"
        //             ),
        //         ));

        //         $response = curl_exec($curl);
        //         $err = curl_error($curl);

        //         curl_close($curl);
        //     }
        // }

        return redirect()->route('job_request.index')
        ->with('success', 'Job Request Added Successfully.');
    }

    public function edit(JobRequest $job_request)
    {
        $start_time = explode(":",$job_request->start_time);
        $end_time = explode(":",$job_request->end_time);
        $jobCategory = JobCategory::get();
        $client = Client::selectRaw("DISTINCT UPPER(client_name) as client_name")->get();
        $client_selected = Client::where('id',$job_request->client_id)->first();
        $supervisor = Client::where('client_name',$client_selected->client_name)->get();
        
        return view('content.jobRequest.edit', compact('job_request','jobCategory','client_selected','client','supervisor','start_time','end_time'));
    }

    public function update(Request $request)
    {
        $job_request_id = $request->route('id');
        $request->validate([
            'client_id' => 'required',
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
            'client_id',
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
