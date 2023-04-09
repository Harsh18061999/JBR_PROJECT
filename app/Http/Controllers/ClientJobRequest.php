<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\Client\CurrentJobRequest;
use App\Models\JobRequest;
use App\Models\Supervisor;
use App\Models\Client;
use App\Models\JobCategory;
class ClientJobRequest extends Controller
{
    public function index(CurrentJobRequest $dataTable){
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
        return $dataTable->render('content.ClientJob.index',compact('supervisor','client','role_name','jobCategory'));
    }
}
