<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeTimeSheet;
use App\Models\JobConfirmation;
use App\Models\VerifyToken;
use App\DataTables\EmployeeTimeSheetDataTable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
class EmployeeTimeSheetController extends Controller
{
    public function index(EmployeeTimeSheetDataTable $dataTable)
    {
        return $dataTable->render('content.employeeTimesheet.index');
    }

    public function create($id)
    {
        $job_details = JobConfirmation::where('id', $id)->first();
        if ($job_details) {
            $job_date = '';
            $time_sheet_status = 0;
            $all_date = [];

            $period = CarbonPeriod::create($job_details->job->job_date, $job_details->job->end_date);

            foreach ($period as $date) {
                $all_date[] = $date->format('Y-m-d');
            }

            $time_sheet = EmployeeTimeSheet::where('job_confirmations_id', $id)
                ->latest()
                ->first();
            if ($time_sheet && in_array($time_sheet->job_date, $all_date)) {
                $key = array_search($time_sheet->job_date, $all_date) + 1;
                if (isset($all_date[$key])) {
                    $job_date = $all_date[$key];
                } else {
                    return redirect()->route('employee_timesheet.index');
                }
            } else {
                $job_date = $all_date[0];
            }
            if(count($all_date) == 1){
                $time_sheet_status = 1;
            }else if($job_date == $all_date[count($all_date)-1]){
                $time_sheet_status = 1;
            }
            return view('content.employeeTimesheet.create', compact('job_details','job_date','time_sheet_status'));
        } else {
            return redirect()
                ->route('employee_timesheet.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function store(Request $request)
    {
        $job_status = $request->time_sheet == 0 ? '1' : '2';
        JobConfirmation::where('id',$request->job_confirmations_id)->update([
            "time_sheet" => $request->time_sheet,
            'job_status' => $job_status
        ]);
        EmployeeTimeSheet::create($request->all());
        return redirect()
        ->route('employee_timesheet.index')
        ->with('success', 'Something went wrong.');
    }

    public function getTimeSheet(Request $request){
        $tieme_sheet = EmployeeTimeSheet::where('job_confirmations_id',$request->id)->get()->toArray();
        return $tieme_sheet;
    }

    public function timeSheetMessage(Request $request){
        $job = JobConfirmation::with('employee')->where('id',$request->job_id)->first()->toArray();
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        if($job){
        $token = Str::random(30);
        $message_status = VerifyToken::create([
            'token' => $token,
            'job_confirmation_id' => $request->job_id
        ]);
        $first_name =  $job['employee']['first_name'];
        $last_name =  $job['employee']['last_name'];
        
        $message = "Hello $first_name $last_name , \n";
        $message .= "Please uploade your time schedule below given link. \n";
        $message .= route('timeSheet',$token);

        $number = '+'.$job['employee']['countryCode'].$job['employee']['contact_number'];

        $send_message = sendMessage($number,$message);
        $data['success'] = true;
        $data['message'] = 'Message Has Been Sent SuccessFully.';
        }
        return $data;
    }

    public function frontTimesheet($token){
        $verify_token = VerifyToken::where('token',$token)->first();
        if($verify_token){
            $job_details = JobConfirmation::where('id', $verify_token->job_confirmation_id)->first();
            if($job_details->job_status == 2){
                return redirect()->route('success');
            } else {
                $job_date = '';
                $time_sheet_status = 0;
                $all_date = [];
    
                $period = CarbonPeriod::create($job_details->job->job_date, $job_details->job->end_date);
    
                foreach ($period as $date) {
                    $all_date[] = $date->format('Y-m-d');
                }
    
                $time_sheet = EmployeeTimeSheet::where('job_confirmations_id', $verify_token->job_confirmation_id)
                    ->latest()
                    ->first();
                if ($time_sheet && in_array($time_sheet->job_date, $all_date)) {
                    $key = array_search($time_sheet->job_date, $all_date) + 1;
                    if (isset($all_date[$key])) {
                        $job_date = $all_date[$key];
                    } else {
                        return redirect()->route('employee_timesheet.index');
                    }
                } else {
                    $job_date = $all_date[0];
                }

                if(count($all_date) == 1){
                    $time_sheet_status = 1;
                }else if($job_date == $all_date[count($all_date)-1]){
                    $time_sheet_status = 1;
                }
                return view('content.employeeTimesheet.user_create', compact('job_details','job_date','time_sheet_status'));
            }
        }else{
            return redirect()->route('success');
        }
    }

    public function frontStore(Request $request)
    {
        $job_status = $request->time_sheet == 0 ? '1' : '2';
        JobConfirmation::where('id',$request->job_confirmations_id)->update([
            "time_sheet" => $request->time_sheet,
            'job_status' => $job_status
        ]);
        EmployeeTimeSheet::create($request->all());
        return redirect()->route('success');
    }
}
