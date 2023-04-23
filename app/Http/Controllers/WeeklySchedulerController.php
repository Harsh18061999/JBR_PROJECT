<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobRequest;
use App\Models\Client;
use App\DataTables\WeeklyDataTable;
use Yajra\DataTables\Facades\DataTables;
use Carbon\CarbonPeriod;
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
        // ->whereDate('job_date','>=',$week_start)
        // ->whereDate('job_date','<=',$week_end);
        $data = $model->get()->toArray();
        $all_data = array();
        foreach($data as $k => $value){
            $client_name = $value['supervisor']['client']['client_name'];
            $supervisour = $value['supervisor']['supervisor'];
            $period = CarbonPeriod::create($value['job_date'], $value['end_date']);
    
            foreach ($period as $date) {
                $all_data[$date->format('Y-m-d')][] = [
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
}
