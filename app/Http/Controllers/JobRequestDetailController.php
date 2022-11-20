<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\JobCategory;
use App\Models\JobRequest;
use App\Models\SendMessage;
use App\Models\Employee;

use Yajra\DataTables\Facades\DataTables;
class JobRequestDetailController extends Controller
{
    public function index(){
        $jobCategory = JobCategory::get();
        $client = Client::selectRaw("DISTINCT UPPER(client_name) as client_name")->get();
        return view('content.jobRequestDetail.index',compact('client'));
    }

    public function searchResult(Request $request){
        $jobRequest = JobRequest::with('client','jobCategory');
        if($request->client && $request->supervisour){
            $client = Client::where('id',$request->supervisour)->first();
            $jobRequest->where('client_id',$client->id);
        }else{
            $client = Client::where('client_name','LIKE', '%' . $request->client . '%')->pluck('id')->toArray();
            $jobRequest = $jobRequest->whereIn('client_id',$client);
        }
        $jobRequest = $jobRequest->get()->toArray();
        $result['data'] = array();
        $result['success'] = true;
        if(count($jobRequest) > 0){
            foreach($jobRequest as $k => $value){
                $client = $value['client']['client_name'];
                $supervisor = $value['client']['supervisor'];
                $job = $value['job_category']['job_title'];
                if($value['status'] == 0){
                    $background = 'bg-primary';
                    $status = 'PENDING';

                    $result['data'][] = '          <div class="col-lg-12 mt-3"> 
                    <div class="col-12">
                      <div class="card mb-4">
                        <div class="card-body p-2">
                          <div class="row">
                          <div class="col-lg-3 col-md-3 my-2">
                            <h5 class="m-0 text-center">'.ucwords($client).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                            <h5 class="m-0 text-center">'.ucwords($supervisor).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                            <h5 class="m-0 text-center">'.ucwords($job).'</h5>
                            </div>
                            <div class="col-lg-2 col-md-2 my-2 text-center">
                            <span class="p-2 '.$background.' text-white rounded">'.$status.'</span>
                            </div>
                            <div class="col-lg-1 col-md-1 text-center">
                              <button class="btn btn-primary me-1 show_result" data-jobid="'.$value['id'].'" data-status="true" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$k.'" aria-expanded="false" aria-controls="collapseExample" data-tableid="'.$k.'">
                                <i class="fa-solid fa-filter"></i> 
                              </button>
                            </div>
                          </div>
                          <div class="collapse" id="collapseExample'.$k.'">
                            <hr>
                            <div class="p-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class=""><b>Request Number Of Employee : </b>10</h5>
                                <div class="bg-success text-white rounded p-1 bulkmessage" data-id="'.$value['id'].'" id="bulkmessage'.$k.'" style="display:none;">
                                <i class="mx-2 font-weight-bold pointer fa-brands fa-2x fa-whatsapp"></i>
                                </div>
        
                            </div>
                              <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                <li class="nav-item">
                                  <button type="button" class="nav-link active text-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home'.$k.'" aria-controls="navs-pills-justified-home'.$k.'" aria-selected="true">Regular &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-success">30</span></button>
                                </li>
                                <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile'.$k.'" aria-controls="navs-pills-justified-profile'.$k.'" aria-selected="false">Avilable &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-warning">30</span></button>
                                </li>
                                <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages'.$k.'" aria-controls="navs-pills-justified-messages'.$k.'" aria-selected="false">On Call &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-gray">30</span></button>
                                </li>
                              </ul>
                            </div>
                              <div class="d-grid" style="overflow: auto">
                              <div class="row">
                                <div class="col-md-12 col-xl-12">
                                  <div class="nav-align-top mb-4">
                               
                                    <div class="tab-content border">
                                      <div class="tab-pane fade show active" id="navs-pills-justified-home'.$k.'" role="tabpanel">
                                        <div class="table-responsive text-white">
                                          <table class="table" id="regular'.$k.'" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Message Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="navs-pills-justified-profile'.$k.'" role="tabpanel">
                                        <div class="table-responsive text-white">
                                          <table class="table" id="available'.$k.'" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Message Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade" id="navs-pills-justified-messages'.$k.'" role="tabpanel">
                                        <div class="table-responsive text-white">
                                          <table class="table" id="oncall'.$k.'" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Message Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
        
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                }else if($value['status'] == 1){
                    $background = 'bg-waring';
                    $status = 'ON GOING';

                    $result['data'][] = '<div class="col-lg-12 mt-3"> 
                    <div class="col-12">
                      <div class="card mb-4">
                        <div class="card-body p-2">
                          <div class="row">
                            <div class="col-lg-3 col-md-3 my-2">
                              <h5 class="m-0">'.ucwords($client).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($supervisor).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($job).'</h5>
                            </div>
                            <div class="col-lg-2 col-md-2 my-2 text-center">
                              <span class="p-2 '.$background.' text-white rounded">'.$status.'</span>
                            </div>
                            <div class="col-lg-1 col-md-1 text-center">
                              <button class="btn btn-primary me-1" data-status="" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$k.'" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-solid fa-filter"></i> 
                              </button>
                            </div>
                          </div>
                          <div class="collapse" id="collapseExample'.$k.'">
                            <div class="d-grid d-sm-flex p-3 mt-3">
        
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';

                }else if($value['status'] == 2){
                    $background = 'bg-success';
                    $status = 'COMPLETED';


                    $result['data'][] = '<div class="col-lg-12 mt-3"> 
                    <div class="col-12">
                      <div class="card mb-4">
                        <div class="card-body p-2">
                          <div class="row">
                            <div class="col-lg-3 col-md-3 my-2">
                              <h5 class="m-0">'.ucwords($client).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($supervisor).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($job).'</h5>
                            </div>
                            <div class="col-lg-2 col-md-2 my-2 text-center">
                              <span class="p-2 '.$background.' text-white rounded">'.$status.'</span>
                            </div>
                            <div class="col-lg-1 col-md-1 text-center">
                              <button class="btn btn-primary me-1" data-status="" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$k.'" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-solid fa-filter"></i> 
                              </button>
                            </div>
                          </div>
                          <div class="collapse" id="collapseExample'.$k.'">
                            <div class="d-grid d-sm-flex p-3 mt-3">
        
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                }else if($value['status'] == 3){
                    $background = 'bg-danger';
                    $status = 'NOT COMPLETEDS';


                    $result['data'][] = '<div class="col-lg-12 mt-3"> 
                    <div class="col-12">
                      <div class="card mb-4">
                        <div class="card-body p-2">
                          <div class="row">
                            <div class="col-lg-3 col-md-3 my-2">
                              <h5 class="m-0">'.ucwords($client).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($supervisor).'</h5>
                            </div>
                            <div class="col-lg-3 col-md-3 my-2 ">
                              <h5 class="m-0">'.ucwords($job).'</h5>
                            </div>
                            <div class="col-lg-2 col-md-2 my-2 text-center">
                              <span class="p-2 '.$background.' text-white rounded">'.$status.'</span>
                            </div>
                            <div class="col-lg-1 col-md-1 text-center">
                              <button class="btn btn-primary me-1" data-status="" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$k.'" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-solid fa-filter"></i> 
                              </button>
                            </div>
                          </div>
                          <div class="collapse" id="collapseExample'.$k.'">
                            <div class="d-grid d-sm-flex p-3 mt-3">
        
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                }
             
            }
        }else{
            $result['success'] = false;
        }
        return $result;
    }

    public function regularDataTable(Request $request)
    {
        $message = SendMessage::where('job_request_id',$request->job_id)->pluck('message_status','employee_id')->toArray();
        $employee = Employee::where('status','0');

        // $employee = $employee->with('message')->whereHas('message', function ($query) use ($request) {
        //     $query->where(function ($q) use ($request) {
        //         $q->orWhere('job_request_id', $request->job_id);
        //     });
        // });
        // dd($employee->get()->toArray());
        // if($request->get('search')['value'])
        // {
        //     $value = $request->get('search')['value'];
        //     $abiGta = $abiGta->where('abi_month_of_rates',$value)
        //         ->orWhere('abi_years_of_rates','like','%'.$value.'%')
        //         ->orWhere('abi_files','like','%'.$value.'%');
        // }

        // $searchInputs = $request->input('searchInput') ? array_filter($request->input('searchInput'), function($value) { return $value != ''; }) : [];
        // if(!empty($searchInputs)) {
        //     foreach ($searchInputs as $key => $value) {
        //         if($key == 'abi_month_of_rates') {
        //             $abiGta = $abiGta->where('abi_month_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_years_of_rates') {
        //             $abiGta = $abiGta->where('abi_years_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_files') {
        //             $abiGta = $abiGta->where('abi_files','like',"%$value%");
        //         }
        //     }
        // }

     
        return Datatables::of($employee)
        ->addColumn('action', function($row) use($request) {
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'"></i></div>';
        })
        ->addColumn('message_status', function($row) use($request,$message) {
          if(isset($message[$row->id])){
              if($message[$row->id] == 0){
                  return '<span class="badge bg-label-warning me-1">Pending</span>';
              }
          }else{
              return '<span class="badge bg-label-info me-1">Not Sent</span>';
          }
      })
      ->addIndexColumn()->rawColumns(['action','message_status'])->make(true);
    }

    public function availableDataTable(Request $request)
    {
      $message = SendMessage::where('job_request_id',$request->job_id)->pluck('message_status','employee_id')->toArray();
        $employee = Employee::where('status','1');
        // $employee = $employee->with('message')
        
        // ->whereHas('message', function ($query) use ($request) {
        //     $query->where('job_request_id', $request->job_id);
        //     // $query->where(function ($q) use ($request) {
        //     // });
        // });
  
        // if($request->get('search')['value'])
        // {
        //     $value = $request->get('search')['value'];
        //     $abiGta = $abiGta->where('abi_month_of_rates',$value)
        //         ->orWhere('abi_years_of_rates','like','%'.$value.'%')
        //         ->orWhere('abi_files','like','%'.$value.'%');
        // }

        // $searchInputs = $request->input('searchInput') ? array_filter($request->input('searchInput'), function($value) { return $value != ''; }) : [];
        // if(!empty($searchInputs)) {
        //     foreach ($searchInputs as $key => $value) {
        //         if($key == 'abi_month_of_rates') {
        //             $abiGta = $abiGta->where('abi_month_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_years_of_rates') {
        //             $abiGta = $abiGta->where('abi_years_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_files') {
        //             $abiGta = $abiGta->where('abi_files','like',"%$value%");
        //         }
        //     }
        // }

     
        return Datatables::of($employee)
        ->addColumn('action', function($row) use($request) {
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'"></i></div>';
        })
        ->addColumn('message_status', function($row) use($request,$message) {
            if(isset($message[$row->id])){
                if($message[$row->id] == 0){
                    return '<span class="badge bg-label-warning me-1">Pending</span>';
                }
            }else{
                return '<span class="badge bg-label-info me-1">Not Sent</span>';
            }
        })
        ->addIndexColumn()->rawColumns(['action','message_status'])->make(true);
    }

    public function onCallDataTable(Request $request)
    {
      $message = SendMessage::where('job_request_id',$request->job_id)->pluck('message_status','employee_id')->toArray();
        $employee = Employee::where('status','5');
        // $employee = $employee->with('message')->whereHas('message', function ($query) use ($request) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('job_request_id', $request->job_id);
        //     });
        // });
        // if($request->get('search')['value'])
        // {
        //     $value = $request->get('search')['value'];
        //     $abiGta = $abiGta->where('abi_month_of_rates',$value)
        //         ->orWhere('abi_years_of_rates','like','%'.$value.'%')
        //         ->orWhere('abi_files','like','%'.$value.'%');
        // }

        // $searchInputs = $request->input('searchInput') ? array_filter($request->input('searchInput'), function($value) { return $value != ''; }) : [];
        // if(!empty($searchInputs)) {
        //     foreach ($searchInputs as $key => $value) {
        //         if($key == 'abi_month_of_rates') {
        //             $abiGta = $abiGta->where('abi_month_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_years_of_rates') {
        //             $abiGta = $abiGta->where('abi_years_of_rates','like',"%$value%");
        //         }
        //         if($key == 'abi_files') {
        //             $abiGta = $abiGta->where('abi_files','like',"%$value%");
        //         }
        //     }
        // }

     
        return Datatables::of($employee)
        ->addColumn('action', function($row) use($request) {
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'"></i></div>';
        })
        ->addColumn('message_status', function($row) use($request,$message) {
          if(isset($message[$row->id])){
              if($message[$row->id] == 0){
                  return '<span class="badge bg-label-warning me-1">Pending</span>';
              }
          }else{
              return '<span class="badge bg-label-info me-1">Not Sent</span>';
          }
      })
      ->addIndexColumn()->rawColumns(['action','message_status'])->make(true);
    }

    public function sendMessageJob(Request $request){
        $job = JobRequest::where('id',$request->job_id)->first();
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        if($job){
            $message = SendMessage::where('employee_id',$request->employee_id)
            ->where('job_request_id',$job->id)
            ->whereDate('job_date',$job->job_date)->first();
            if($message){
                $data['success'] = true;
                $data['message'] = 'Your Request Under Process.';
            }else{
                SendMessage::create([
                    'employee_id' => $request->employee_id,
                    'job_request_id' => $job->id,
                    'job_date' => $job->job_date
                ]);
                $data['success'] = true;
                $data['message'] = 'Your Request Under Process.';
            }
        }
        return $data;
    }

    public function sendBulkMessageJob(Request $request){
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        if(count($request->employee_id) > 0){
            $job = JobRequest::where('id',$request->job_id)->first();
            foreach($request->employee_id as $k => $value){
                $message = SendMessage::where('employee_id',$value)
                ->where('job_request_id',$job->id)
                ->whereDate('job_date',$job->job_date)->first();
                if(!$message){
                    SendMessage::create([
                        'employee_id' => $value,
                        'job_request_id' => $job->id,
                        'job_date' => $job->job_date
                    ]);
                }
            }
            $data['success'] = true;
            $data['message'] = 'Your Request Under Process.';
        }
        return $data;
    }
}
