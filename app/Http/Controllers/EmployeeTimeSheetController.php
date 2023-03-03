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
        $orderDetails = $request->only([
            'job_confirmations_id',
            'job_date',
            'break_time'
        ]);
        $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;

        $job_status = $request->time_sheet == 0 ? '1' : '2';
        JobConfirmation::where('id',$request->job_confirmations_id)->update([
            "time_sheet" => $request->time_sheet,
            'job_status' => $job_status
        ]);
        EmployeeTimeSheet::create($orderDetails);
        return redirect()
        ->route('employee_timesheet.index')
        ->with('success', 'Something went wrong.');
    }

    public function getTimeSheet(Request $request){
        $tieme_sheet = EmployeeTimeSheet::where('job_confirmations_id',$request->id)->get();
        $tieme_sheet->map(function ($value) {
            
            $start_time = explode(":",$value->start_time);
            $end_time = explode(":",$value->end_time);

            $total_minutes = (int)($end_time[1] - $start_time[1]);

            $break_time = $value->break_time;
            if($end_time[2] == "PM"){
                $end_hours = $end_time[0] + 12;
            }else{
                $end_hours = $end_time[0];
            }

            $total_hours = (int)($end_hours - $start_time[0])*60;
            $value->total = ($total_hours - $break_time)/60;
            return $value;
        });
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
        $data['message'] = 'Message Has Been Sent successfully.';
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
        $orderDetails = $request->only([
            'job_confirmations_id',
            'job_date',
            'break_time'
        ]);
        $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;
        $job_status = $request->time_sheet == 0 ? '1' : '2';
        JobConfirmation::where('id',$request->job_confirmations_id)->update([
            "time_sheet" => $request->time_sheet,
            'job_status' => $job_status
        ]);
        EmployeeTimeSheet::create($orderDetails);
        return redirect()->route('success');
    }
}
