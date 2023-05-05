<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobRequest;
use App\Models\JobConfirmation;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Country;
use App\Models\Leave;
use App\Models\SendMessage;
use App\DataTables\WeeklyDataTable;
use Yajra\DataTables\Facades\DataTables;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use DB;
class WeeklySchedulerController extends Controller
{
    public function index(){
        $user = auth()->user();
        $client = Client::get();
        $role = $user->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $jobCategory = JobCategory::get();

        if($user->hasRole('admin')){
            $supervisor = array();    
        }else{
            $supervisor = new Supervisor;
            $supervisor = $supervisor->where('client_id',$user->client->id)->get();
        }
        $model = new JobRequest;
        $model = $model->with(['employees','supervisor.client','jobCategory','jobConfirmation']);
        $data = $model->get()->toArray();
        $all_data = array();
        foreach($data as $k => $value){
            $client_name = $value['supervisor']['client']['client_name'];
            $supervisour = $value['supervisor']['supervisor'];
            $period = CarbonPeriod::create($value['job_date'], $value['end_date']);
    
            foreach ($period as $date) {
                $all_data[$date->format('Y-m-d')][] = [
                    "id" => $value['id'],
                    "client_name" => $client_name,
                    "supervisour" => $supervisour,
                    "employee" => $value['employees']
                ] ;
            }
        }
        // dd($all_data);
        // foreach($all_data as $k => $value){
        //     // dd($value);
        //     foreach ($value as $item){
        //         dd($item['client_name']);
        //     }
        // }
        return view('content.weeklyScheduler.index',compact('supervisor','client','role_name','jobCategory','all_data'));
    }

    public function reallocateJob(Request $request){
        // dd($request->all());
        $job = JobRequest::where('id',$request->job_id)->first();
        $jobList = JobRequest::whereDate('job_date','<=',$request->date)
        ->whereDate('end_date','>=',$request->date)->pluck('id')->toArray();

        $notavailable = JobConfirmation::whereIn('job_id',$jobList)->pluck('employee_id')->toArray();

        $available = Employee::whereNotIn('id',$notavailable)->get();
        $response['success'] = $available->count() > 0 ? true : false;
        $response['employee'] = $available;
        $response['job_id'] = $request->job_id;
        $response['job_date'] = $request->date;
        $response['employee_id'] = $request->employee_id;
        return $response;
    }

    public function leave_request(Request $request){
        Leave::create([
            "job_id" => $request->job_id,
            "employee_id" => $request->re_allocate_employee_id,
            "leave_date" => $request->reallocate_date
        ]);
        $employee = Employee::where('id',$request->employee_available)->first();

        $job = JobRequest::where('id',$request->job_id)->first();
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        DB::beginTransaction();
        try{
          if($job){
              $message = SendMessage::where('employee_id',$request->re_allocate_employee_id)
              ->where('job_request_id',$job->id)
              ->whereDate('job_date',$job->reallocate_date)->first();
              if($message){
                  $data['success'] = true;
                  $data['message'] = 'Message All Redy Been Send.';
              }else{
                  $message_status = SendMessage::create([
                      'confirmation_id' => Str::random(30),
                      'employee_id' => $employee->id,
                      'job_request_id' => $job->id,
                      'job_date' => $request->reallocate_date,
                      "is_reallocate" => '1'
                  ]);
                  $message_data = SendMessage::with('employee')->where('id',$message_status->id)
                    ->first()->toArray();
  
                  $first_name =  $message_data['employee']['first_name'];
                  $last_name =  $message_data['employee']['last_name'];
                  
                  $message = "Hello $first_name $last_name , \n";
                  $message .= "Here's an interesting job that we think might be relevant for you. \n";
                  $message .= "Please confirm your job below given link. \n";
                  $message .= route('confirm_job',$message_data['confirmation_id']);
  
                  $country = Country::where('id',$message_data['employee']['countryCode'])->first();
                  $number = '+'.$country->country_code.$message_data['employee']['contact_number'];
  
                  $send_message = sendMessage("+919737918132",$message);
                  if($send_message){
                    SendMessage::where('id',$message_data['id'])
                      ->update([
                        'message_status' => '1'
                      ]);
                      $data['success'] = true;
                      $data['message'] = 'Message Has Been Sent successfully.';
                  }else{
                    SendMessage::where('id',$message_data['id'])
                      ->update([
                        'message_status' => '2'
                      ]);
                      $data['success'] = false;
                      $data['message'] = 'Somthing Went To Wrong.';
                  }
              }
          }
          DB::commit();
          return $data;
        }catch (Exception $e) {
          // drakify('error');
            DB::rollback();
            return redirect()->back()
                    ->withError('Try again');
        }
    }
}
