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
use App\Models\ReaAllocate;
use App\Models\SendMessage;
use App\Models\Supervisor;
use App\DataTables\WeeklyDataTable;
use Yajra\DataTables\Facades\DataTables;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $client = Client::get();
        $role = $user->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $jobCategory = JobCategory::get();

        $model = new JobRequest();
        $role = auth()
            ->user()
            ->getRoleNames()
            ->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        if ($role_name != 'admin') {
        } else {
        }

        $supervisor_id = [];
        $supervisor = [];
        if ($user->hasRole('admin')) {
            $client_name = Client::where('id',$request->client_name)->first();
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } elseif ($request->client_name && $request->client_name != '') {
                $client_id = Supervisor::where('client_id', $request->client_name)
                    ->pluck('id')
                    ->toArray();
                $model = $model->whereIn('supervisor_id', $client_id);
            }
            
        } else {
            $client_name = Client::where('id',auth()->user()->client_id)->first();
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } else {
                $supervisor_id = Supervisor::where('client_id', auth()->user()->client_id)
                    ->pluck('id')
                    ->toArray();
                if (!empty($supervisor_id)) {
                    $model = $model->whereIn('supervisor_id', $supervisor_id);
                }
            }
            $supervisor = new Supervisor();
            $supervisor = $supervisor->where('client_id', $user->client->id)->get();
            $supervisor_id = $supervisor->pluck('id')->toArray();
        }

        if ($request->custome_range == 2) {
            $previous_week = strtotime('-1 week +1 day');
            $start_week = strtotime('last sunday midnight', $previous_week);
            $end_week = strtotime('next saturday', $start_week);
            $week_start = date('Y-m-d', $start_week);
            $week_end = date('Y-m-d', $end_week);
        } elseif ($request->custome_range == 3) {
            $week_start = $request->job_date;
            $week_end = $request->end_date;
        } else {
            $day = date('w');
            $week_start = date('Y-m-d-', strtotime('-' . $day . ' days'));
            $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        }
        
        $model = $model->whereDate('job_date', '>=', $week_start)->whereDate('job_date', '<=', $week_end);
        $job_id = $model->pluck('id')->toArray();

        $job = JobConfirmation::with(['employee','timeSheet','job.supervisor'])->whereIn('job_id',$job_id)->get();
        $r_job = ReaAllocate::with(['employee','timeSheet','job.supervisor'])->whereIn('job_id',$job_id)->get();
        $all_data = [];
        if($client_name){

            foreach($job as $k => $value){
                if(count($value->timeSheet) > 0){
                    foreach($value->timeSheet as $timesheet){
                        $start_time = explode(':', $timesheet->start_time);
                        $end_time = explode(':', $timesheet->end_time);
                        
                        $total_minutes = (int) ($end_time[1] - $start_time[1]);
                        
                        $break_time = $timesheet->break_time;
                        
                        $total_hours = (int) ($end_time[0] - $start_time[0]) * 60;
                        $ottime = 0.00;
                        $total = number_format((float) (($total_hours + $total_minutes) - ($break_time)) / 60, 2, '.', ''); 
                        if($total > 8){
                            $ottime = $total - 8;
                            $total = $total - $ottime;
                        }
                        $all_data[] = [
                            "date" => $timesheet->job_date,
                            "employee" => $value->employee->first_name,
                            "client" => $client_name->client_name,
                            "Supervisor" =>  $value->job->supervisor->supervisor,
                            "start_time" => $timesheet->start_time,
                            "break_time" => $timesheet->break_time,
                            "end_time" => $timesheet->end_time,
                            "ot_time" => $ottime,
                            "hours" => $total < 0 ? 0 : $total,
                            "value" => $value,
                            "time_sheet" => true,
                            "re_allocate" => false
                        ];
                    }
                }else{
                    $all_data[] = [
                        "date" => $value->job->job_date,
                        "employee" => $value->employee->first_name,
                        "client" => $client_name->client_name,
                        "Supervisor" =>  $value->job->supervisor->supervisor,
                        "start_time" => "N/A",
                        "break_time" => "N/A",
                        "end_time" => "N/A",
                        "ot_time" => "N/A",
                        "hours" => "N/A",
                        "value" => $value,
                        "time_sheet" => false,
                        "re_allocate" => false
                    ];
                }
            }
    
            foreach($r_job as $k => $value){
                if(count($value->timeSheet) > 0){
                    foreach($value->timeSheet as $timesheet){
                        $start_time = explode(':', $timesheet->start_time);
                        $end_time = explode(':', $timesheet->end_time);
                        
                        $total_minutes = (int) ($end_time[1] - $start_time[1]);
                        
                        $break_time = $timesheet->break_time;
                        
                        $total_hours = (int) ($end_time[0] - $start_time[0]) * 60;
                        $ottime = 0.00;
                        $total = number_format((float) (($total_hours + $total_minutes) - ($break_time)) / 60, 2, '.', ''); 
                        if($total > 8){
                            $ottime = $total - 8;
                            $total = $total - $ottime;
                        }
                        $all_data[] = [
                            "date" => $timesheet->job_date,
                            "employee" => $value->employee->first_name,
                            "client" => $client_name->client_name,
                            "Supervisor" =>  $value->job->supervisor->supervisor,
                            "start_time" => $timesheet->start_time,
                            "break_time" => $timesheet->break_time,
                            "end_time" => $timesheet->end_time,
                            "ot_time" => $ottime,
                            "hours" => $total < 0 ? 0 : $total,
                            "value" => $value,
                            "time_sheet" => true,
                            "re_allocate" => true
                        ];
                    }
                }else{
                    $all_data[] = [
                        "date" => $value->re_allocate_date,
                        "employee" => $value->employee->first_name,
                        "client" => $client_name->client_name,
                        "Supervisor" =>  $value->job->supervisor->supervisor,
                        "start_time" => "N/A",
                        "break_time" => "N/A",
                        "end_time" => "N/A",
                        "ot_time" => "N/A",
                        "hours" => "N/A",
                        "value" => $value,
                        "time_sheet" => false,
                        "re_allocate" => true
                    ];
                }
            }
        }



        $search = [
            'custome_range' => $request->custome_range ? $request->custome_range : 1,
            'job_date' => $request->job_date,
            'end_date' => $request->end_date,
            'supervisor' => $request->supervisor,
            'client_name' => $request->client_name,
        ];
   
        return view('content.report.index', compact('supervisor', 'client', 'role_name', 'jobCategory', 'all_data', 'search'));
    }

    public function export(Request $request){
        // dd($request->all());
        $user = auth()->user();
        $client = Client::get();
        $role = $user->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $jobCategory = JobCategory::get();

        $model = new JobRequest();
        $role = auth()
            ->user()
            ->getRoleNames()
            ->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        if ($role_name != 'admin') {
        } else {
        }

        $supervisor_id = [];
        $supervisor = [];
        if ($user->hasRole('admin')) {
            $client_name = Client::where('id',$request->client_name)->first();
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } elseif ($request->client_name && $request->client_name != '') {
                $client_id = Supervisor::where('client_id', $request->client_name)
                    ->pluck('id')
                    ->toArray();
                $model = $model->whereIn('supervisor_id', $client_id);
            }
            
        } else {
            $client_name = Client::where('id',auth()->user()->client_id)->first();
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } else {
                $supervisor_id = Supervisor::where('client_id', auth()->user()->client_id)
                    ->pluck('id')
                    ->toArray();
                if (!empty($supervisor_id)) {
                    $model = $model->whereIn('supervisor_id', $supervisor_id);
                }
            }
            $supervisor = new Supervisor();
            $supervisor = $supervisor->where('client_id', $user->client->id)->get();
            $supervisor_id = $supervisor->pluck('id')->toArray();
        }

        if ($request->custome_range == 2) {
            $previous_week = strtotime('-1 week +1 day');
            $start_week = strtotime('last sunday midnight', $previous_week);
            $end_week = strtotime('next saturday', $start_week);
            $week_start = date('Y-m-d', $start_week);
            $week_end = date('Y-m-d', $end_week);
        } elseif ($request->custome_range == 3) {
            $week_start = $request->job_date;
            $week_end = $request->end_date;
        } else {
            $day = date('w');
            $week_start = date('Y-m-d-', strtotime('-' . $day . ' days'));
            $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        }

        $model = $model->whereDate('job_date', '>=', $week_start)->whereDate('job_date', '<=', $week_end);
        $job_id = $model->pluck('id')->toArray();

        $job = JobConfirmation::with(['employee','timeSheet','job.supervisor'])->whereIn('job_id',$job_id)->get();
        $r_job = ReaAllocate::with(['employee','timeSheet','job.supervisor'])->whereIn('job_id',$job_id)->get();
        $all_data = [];
        foreach($job as $k => $value){
            if(count($value->timeSheet) > 0){
                foreach($value->timeSheet as $timesheet){
                    $start_time = explode(':', $timesheet->start_time);
                    $end_time = explode(':', $timesheet->end_time);
                    
                    $total_minutes = (int) ($end_time[1] - $start_time[1]);
                    
                    $break_time = $timesheet->break_time;
                    
                    $total_hours = (int) ($end_time[0] - $start_time[0]) * 60;
                    $ottime=0.00;
                    $total = number_format((float) (($total_hours + $total_minutes) - ($break_time)) / 60, 2, '.', ''); 
                    if($total > 8){
                        $ottime = $total - 8;
                        $total = $total - $ottime;
                    }
                    $all_data[] = [
                        "date" => $timesheet->job_date,
                        "employee" => $value->employee->first_name,
                        "client" => $client_name->client_name,
                        "Supervisor" =>  $value->job->supervisor->supervisor,
                        "start_time" => $timesheet->start_time,
                        "break_time" => $timesheet->break_time,
                        "end_time" => $timesheet->end_time,
                        "ot_time" => $ottime,
                        "hours" => $total < 0 ? 0 : $total
                    ];
                }
            }else{
                $all_data[] = [
                    "date" => $value->job->job_date,
                    "employee" => $value->employee->first_name,
                    "client" => $client_name->client_name,
                    "Supervisor" =>  $value->job->supervisor->supervisor,
                    "start_time" => "N/A",
                    "break_time" => "N/A",
                    "end_time" => "N/A",
                    "ot_time" => "N/A",
                    "hours" => "N/A"
                ];
            }
        }

        foreach($r_job as $k => $value){
            if(count($value->timeSheet) > 0){
                foreach($value->timeSheet as $timesheet){
                    $start_time = explode(':', $timesheet->start_time);
                    $end_time = explode(':', $timesheet->end_time);
                    
                    $total_minutes = (int) ($end_time[1] - $start_time[1]);
                    
                    $break_time = $timesheet->break_time;
                    
                    $total_hours = (int) ($end_time[0] - $start_time[0]) * 60;
                    $ottime=0.00;
                    $total = number_format((float) (($total_hours + $total_minutes) - ($break_time)) / 60, 2, '.', ''); 
                    if($total > 8){
                        $ottime = $total - 8;
                        $total = $total - $ottime;
                    }
                    $all_data[] = [
                        "date" => $timesheet->job_date,
                        "employee" => $value->employee->first_name,
                        "client" => $client_name->client_name,
                        "Supervisor" =>  $value->job->supervisor->supervisor,
                        "start_time" => $timesheet->start_time,
                        "break_time" => $timesheet->break_time,
                        "end_time" => $timesheet->end_time,
                        "ot_time" => $ottime,
                        "hours" => $total < 0 ? 0 : $total,
                    ];
                }
            }else{
                $all_data[] = [
                    "date" => $value->re_allocate_date,
                    "employee" => $value->employee->first_name,
                    "client" => $client_name->client_name,
                    "Supervisor" =>  $value->job->supervisor->supervisor,
                    "start_time" => "N/A",
                    "break_time" => "N/A",
                    "end_time" => "N/A",
                    "ot_time" => "N/A",
                    "hours" => "N/A",
                ];
            }
        }
        $filename = date('Y-m-d')."_Report_Export";
        return Excel::download(new ReportExport($all_data), $filename.'.xlsx');
    }
}
