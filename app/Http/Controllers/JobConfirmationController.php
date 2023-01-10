<?php

namespace App\Http\Controllers;

use App\Models\SendMessage;
use App\Models\Employee;
use App\Models\EmployeeDataEntryPoint;
use App\Models\JobConfirmation;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use DB;

class JobConfirmationController extends Controller
{
    public function confirmJob($token){
        $message_data = SendMessage::with('employee.jobCategory','jobRequest.client')->where('confirmation_id',$token)->first()->toArray();
        $employee_data = EmployeeDataEntryPoint::where('employee_id',$message_data['employee_id'])->first();
        if(!$employee_data){
            return redirect()->route('front.job_request',$token);
        }
        $c_job = JobConfirmation::where('job_id',$message_data['job_request_id'])
            ->where('employee_id',$message_data['employee_id'])
            ->where('status','1')->first();
        if(!$c_job){
            return view('content.user.jobConfirm')->with(['message_data' => $message_data]);
        }else{
            return view('content.user.congratulations');
        }
    }

    public function acceptJob(Request $request){
        JobConfirmation::updateOrCreate([
            'employee_id' => $request->employee_id,
            'job_id' => $request->job_id,
        ],['status' => '1']);

        $job_status = JobRequest::where('id',$request->job_id)
        ->update([
            'job_message_status' => DB::raw('job_message_status + 1'),
        ]);

        $employee = Employee::where('id',$request->employee_id)->first();
        $job = JobRequest::with(['client','jobCategory'])->withCount('jobConfirmation')->where('id',$request->job_id)->first()->toArray();

        $first_name =  $employee->first_name;
        $last_name =  $employee->last_name;
        
        $message = "👏 Congratulations $first_name $last_name on your job confirmation, \n";
        $message .= "Client Name : ".$job['client']['client_name']." \n";
        $message .= "Address : ".$job['client']['client_address']." \n";
        $message .= "Start Date : ".$job['job_date']." \n";
        $message .= "End Date : ".$job['end_date']." \n";
        $message .= "Start Time : ".$job['start_time']." \n";
        $message .= "End Time : ".$job['end_time']." \n";

        $number = '+'.$employee->countryCode.$employee->contact_number;

        $send_message = sendMessage($number,$message);
        if($job['no_of_employee'] == ($job['job_confirmation_count']+1)){
            JobRequest::where('id',$request->job_id)->update([
                "status" => '1'
            ]);
        }
        return view('content.user.congratulations');
    }

    public function cancellJob(Request $request){
        JobConfirmation::updateOrCreate([
            'employee_id' => $request->employee_id,
            'job_id' => $request->job_id,
        ],['status' => '0']);
        return view('content.user.cancell');
    }
}
