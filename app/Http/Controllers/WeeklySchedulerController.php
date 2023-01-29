<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobRequest;
use App\Models\Client;
use Yajra\DataTables\Facades\DataTables;
class WeeklySchedulerController extends Controller
{
    public function index(){
        $jobCategory = JobCategory::get();
        $client = Client::get();
        return view('content.weeklyScheduler.index',compact('jobCategory','client'));
    }

    public function weeklyJobDataTable(Request $request){
        if($request->weekly == 0){
            $day = date('w');
            $week_start = date('Y-m-d-', strtotime('-'.$day.' days'));
            $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        }else{
            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);
            
            $week_start = date("Y-m-d",$start_week);
            $week_end = date("Y-m-d",$end_week);
        }

        
        $jobRequest = JobRequest::with(['employees','client','jobCategory'])
        ->where('job_date','>=',$week_start)
        ->where('end_date','<=',$week_end);
        if($request->client_name){

            $client = Client::where('client_name',$request->client_name);

            if($request->supervisor){
                $client = $client->where('id',$request->supervisor);
            }

            $client = $client->pluck('id')->toArray();
            $jobRequest =  $jobRequest->whereIn('client_id',$client);;
            if($request->job_title){
                $jobRequest = $jobRequest->where('job_id',$request->job_title);
            }
        }
      
        return Datatables::of($jobRequest)
        ->addColumn('Date', function($row)  {
            return "<span> <div class='text-start'><p>$row->job_date <i class='fa-solid fa-arrow-right mx-2'></i> $row->end_date
                </p><p>$row->start_time <i class='fa-solid fa-clock mx-2'></i> $row->end_time</p></div> </span>";       
        })
        ->addColumn('client_name', function($row)  {
          return isset($row->client) ? $row->client->client_name : 'N/A';       
         })
         ->addColumn('supervisor', function($row)  {
          return  isset($row->client) ? $row->client->supervisor : 'N/A';    
         })
         ->addColumn('employee', function($row)  {
                $div = "<div class='row'>";
                foreach($row->employees as $employee){
                    $div .= "<div class='col-md-6 mt-2'>
                        <span class='badge bg-label-primary me-1'>
                            <div class='d-flex align-items-center'> 
                               <p class='m-0'> $employee->first_name $employee->last_name <br><br>
                                $employee->contact_number </p>
                                <i class='fa-solid fa-eye mx-2'></i>
                            </div>
                        </span>
                    </div>";
                }
                $div .="</div>";
                return $div;
        })
        ->addColumn('status', function($row)  {
            if($row->status == 0){
                return '<span class="badge bg-label-primary me-1">Pending</span>';
            }else if($row->status == 1){
                return '<span class="badge bg-label-warning me-1">On Going</span>';
            }else if($row->status == 2){
                return '<span class="badge bg-label-warning me-1">Completed</span>';
            }
        })
        ->addIndexColumn()->rawColumns(['Date','client_name','employee','status'])->make(true);
    }
}
