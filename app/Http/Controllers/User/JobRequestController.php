<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function job_request(){
        return view('content.user.jobRequest.job_request');
    }
}
