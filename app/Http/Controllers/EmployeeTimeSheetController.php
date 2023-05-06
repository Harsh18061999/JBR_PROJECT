<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeTimeSheet;
use App\Models\JobConfirmation;
use App\Models\VerifyToken;
use App\Models\Client;
use App\Models\JobCategory;
use App\Models\Supervisor;
use App\DataTables\JobListTable;
use Carbon\Carbon;
use App\Models\JobRequest;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\ReaAllocate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use File;

class EmployeeTimeSheetController extends Controller
{
    public function index(JobListTable $dataTable)
    {
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
        return $dataTable->render('content.employeeTimesheet.joblist',compact('supervisor','client','role_name','jobCategory'));
        // return $dataTable->render('content.employeeTimesheet.index');
    }

    public function timeSheetStatus($id){
        $jobReuest = JobRequest::with(['supervisor.client'])->where('id',$id)->first();
        // dd($jobReuest);
        $employeeDetails = JobConfirmation::with(['employee','timeSheet'])->where('job_id',$id)->get();
        $reallocate = ReaAllocate::with(['employee','timeSheet'])->where('job_id',$id)->groupBy('employee_id')->get();
        // foreach($employeeDetails as $job){
        //     dd($job->timeSheet);
        // }
        return view('content.employeeTimesheet.timesheetindex',with([
            'jobReuest' => $jobReuest,
            'employeeDetails' => $employeeDetails,
            'reallocateJob' => $reallocate
        ]));
    }

    public function datatable(Request $request){
        $job = JobConfirmation::get();

        return Datatables::of($job)
        ->rawColumns(['action','job_status','time_sheet_status','job_title','client','supervisor'])
        ->addColumn('employee_name', function($query){
            return isset($query->employee) ? $query->employee->first_name .' '.$query->employee->last_name : '';
        })
        ->addColumn('action', function($query){
            if($query->job_status == 2){
                return "N/A";
            }else{
                return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="job_alert" value="'.$query->id.'" /><i class="mx-2 time_sheet_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$query->id.'"></i></div>';
            }
        })
        ->addColumn('job_date', function($query){
            return isset($query->job) ? $query->job->job_date : '';
        })
        ->addColumn('job_title', function($query){
            return isset($query->job) ? $query->job->jobCategory->job_title : '';
        })
        ->addColumn('client', function($query){
            return isset($query->job) ? $query->job->supervisor->client->client_name : '';
        })
        ->addColumn('supervisor', function($query){
            return isset($query->job) ? $query->job->supervisor->supervisor : '';
        })
        ->addColumn('job_time', function($query){
            return isset($query->job) ? $query->job->start_time : '0:00';
        })
        ->addColumn('job_status', function($query){
            if($query->job_status == 0){
                return '<span class="badge bg-label-primary me-1">Pending</span>';
            }else if($query->job_status == 1){
                return '<span class="badge bg-label-warning me-1">On Going</span>';
            }else if($query->job_status == 2){
                return '<span class="badge bg-label-success me-1">Completed</span>';
            }
        })
        ->addColumn('time_sheet_status', function($query){
            if($query->time_sheet == 0){
                return '<a href="'.route('employee_timesheet.create',$query->id).'"><i class="fa-solid fa-pen-to-square pe-auto" title="Add workig time"></i></a><span class="badge bg-label-primary me-1">Pending</span>';
            }else if($query->time_sheet == 1){
                return '<span class="badge bg-label-success me-1">Completed</span>';
            }
        })
        ->setRowId('id')->make(true);
    }

    public function create($id,Request $request)
    {
        $reallocate = 0;
        if($request->employee_id){
            $job_details = ReaAllocate::find($id);
            $job_details1 = ReaAllocate::where("employee_id",$request->employee_id)
                ->where("job_id",$request->job_id)->get();
            $all_date = $job_details1->pluck('re_allocate_date')->toArray();
            $time_sheet_status = 1;
            $reallocate = 1;
            return view('content.employeeTimesheet.create', compact('job_details','all_date','time_sheet_status','reallocate'));
        }
        $job_details = JobConfirmation::where('id', $id)->first();
        if ($job_details) {
            $job_date = '';
            $time_sheet_status = 0;
            $all_date = [];

            $period = CarbonPeriod::create($job_details->job->job_date, $job_details->job->end_date);

            foreach ($period as $date) {
                $all_date[] = $date->format('Y-m-d');
            }
            // dd($all_date);
            $time_sheet_status = 1;
            return view('content.employeeTimesheet.create', compact('job_details','all_date','time_sheet_status','reallocate'));
        } else {
            return redirect()
                ->route('employee_timesheet.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function store(Request $request)
    {    
        $filename = '';
        if($request->has('time_sheet_image')) {
            $uploadedFile = $request->file('time_sheet_image');
            $filename = uniqid(). '.' .File::extension($uploadedFile->getClientOriginalName());
            Storage::disk('local')->putFileAs(
            'public/assets/timesheet',
            $uploadedFile,
            $filename
            );
        }

        if($request->job_reallocate == 1){
            ReaAllocate::where("employee_id",$request->employee_id)
                ->where("job_id",$request->job_id)->update([
                    'time_sheet_image' => $filename,
                ]);
                foreach($request->job_date as $k => $date){
                    EmployeeTimeSheet::create([
                      're_allocation_id' => $request->job_confirmations_id,
                        'time_sheet' => $request->time_sheet,
                        'job_date' => $date,
                        'start_time' => $request->start_time[$k],
                        'break_time' => $request->break_time[$k],
                        'end_time' => $request->end_time[$k],
                    ]);
                }
        }else{
            JobConfirmation::where('id',$request->job_confirmations_id)->update([
                'time_sheet_image' => $filename
            ]);
            foreach($request->job_date as $k => $date){
                EmployeeTimeSheet::create([
                  'job_confirmations_id' => $request->job_confirmations_id,
                    'time_sheet' => $request->time_sheet,
                    'job_date' => $date,
                    'start_time' => $request->start_time[$k],
                    'break_time' => $request->break_time[$k],
                    'end_time' => $request->end_time[$k],
                ]);
            }
        }
        // $orderDetails = $request->only([
        //     'job_confirmations_id',
        //     'job_date',
        //     'break_time'
        // ]);
        // $orderDetails['start_time'] = $request->start_hours.":".$request->start_minutes.":".$request->start_day;
        // $orderDetails['end_time'] = $request->end_hours.":".$request->end_minutes.":".$request->end_day;

        // $job_status = $request->time_sheet == 0 ? '1' : '2';
        // JobConfirmation::where('id',$request->job_confirmations_id)->update([
        //     "time_sheet" => $request->time_sheet,
        //     'job_status' => $job_status
        // ]);
        // EmployeeTimeSheet::create($orderDetails);
        return redirect()
        ->route('employee_timesheet.index')
        ->with('success', 'Time sheet has been update.');
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

    public function saveTimeSheet(Request $request){
        EmployeeTimeSheet::where('id',$request->job_id)->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            "break_time" => $request->break_time
        ]);
        $response['success'] = true;
        $start_time = explode(':', $request->start_time);
        $end_time = explode(':', $request->end_time);
        
        $total_minutes = (int) ($end_time[1] - $start_time[1]);
        
        $break_time = $request->break_time;
        
        $total_hours = (int) ($end_time[0] - $start_time[0]) * 60;
        $total = number_format((float) (($total_hours + $total_minutes) - ($break_time)) / 60, 2, '.', ''); 
        $response['total'] = $total;
        
        return $response;
    }

    public function approve(Request $request){
        if($request->allocate == 1){
            ReaAllocate::where("employee_id",$request->employee_id)
            ->where("job_id",$request->id)->update([
                'time_sheet' => '1'
            ]);
        }else{
            JobConfirmation::where('id',$request->id)
                ->where('employee_id',$request->employee_id)
                ->update([
                    'time_sheet' => '1'
                ]);
        }
        $response['success'] = true;
        return $response;
    }

    public function cancle(Request $request){
        if($request->allocate == 1){
            ReaAllocate::where("employee_id",$request->employee_id)
            ->where("job_id",$request->id)->update([
                'time_sheet' => '0'
            ]);
        }else{
            JobConfirmation::where('id',$request->id)
            ->where('employee_id',$request->employee_id)
            ->update([
                'time_sheet' =>'0'
            ]);
        }
        $response['success'] = true;
        return $response;
    }
}
