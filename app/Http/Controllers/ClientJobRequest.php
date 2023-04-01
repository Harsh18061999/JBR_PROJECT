<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\Client\CurrentJobRequest;
use App\Models\JobRequest;
use App\Models\Supervisor;
class ClientJobRequest extends Controller
{
    public function index(CurrentJobRequest $dataTable){
        $user = auth()->user();
        $Supervisor = Supervisor::where('client_id',$user->client->id)->get();
        $latest = JobRequest::whereIn('supervisor_id',$Supervisor->pluck('id')->toArray())->latest()->first();
        return $dataTable->with('latest', $latest->id)->render('content.ClientJob.index',compact('Supervisor'));
    }
}
