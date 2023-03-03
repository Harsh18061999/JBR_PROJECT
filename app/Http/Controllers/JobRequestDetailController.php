<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\JobCategory;
use App\Models\JobConfirmation;
use App\Models\JobRequest;
use App\Models\SendMessage;
use App\Models\Supervisor;
use App\Models\Employee;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
class JobRequestDetailController extends Controller
{
    public function index(){
        $jobCategory = JobCategory::get();
        $client = Client::get();
        $role = auth()->user()->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $supervisor = array();
        if($role_name != 'admin'){
            $supervisor = Supervisor::where('client_id',auth()->user()->client_id)->get();
        }
        return view('content.jobRequestDetail.index',compact('client','supervisor','role_name'));
    }

    public function searchResult(Request $request){
        $role = auth()->user()->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
       
        $jobRequest = JobRequest::withCount('jobConfirmation')->with('supervisor.client','jobCategory');
        if($request->date && $request->to_date){
          $jobRequest = $jobRequest->where('job_date','>=',$request->date)
          ->where('end_date','<=',$request->to_date);
        }else if($request->date){
          $jobRequest = $jobRequest->whereBetween('job_date', [$request->date, $request->date]);
        }
        if($request->client && $request->supervisour){
            $jobRequest->where('supervisor_id',$request->supervisour);
        }else if($request->client){
            $client = Supervisor::where('client_id',$request->client)->pluck('id')->toArray();
            $jobRequest = $jobRequest->whereIn('supervisor_id',$client);
        }
        if($role_name != 'admin'){
          if($request->supervisour){
            $jobRequest->where('supervisor_id',$request->supervisour);
          }else{
            $supervisor = Supervisor::where('client_id',auth()->user()->client_id)->pluck('id')->toArray();
            $jobRequest = $jobRequest->whereIn('supervisor_id',$supervisor);
          }
        }
        $jobRequest = $jobRequest->get()->toArray();
        $result['data'] = array();
        $result['success'] = true;
        if(count($jobRequest) > 0){
            foreach($jobRequest as $k => $value){
              // dd($value);
                $client = $value['supervisor']['client']['client_name'];
                $supervisor = $value['supervisor']['supervisor'];
                $job = $value['job_category']['job_title'];
                $total = $value['no_of_employee'];
                $start_date = $value['job_date'];
                $end_date = $value['end_date'];
                $c_total = $value['job_confirmation_count'];
                if($value['status'] == 0){
                    $background = 'bg-primary';
                    $status = 'PENDING';
                    $result['data'][] = '          <div class="col-lg-12 mt-3"> 
                    <div class="col-12">
                      <div class="card mb-4">
                        <div class="card-body p-2">
                          <div class="row">
                          <div class="col-md-12 d-flex justify-content-between align-items-center"><p class="mx-2 p-0">Start Date : '.$start_date.'</p><p class="mx-2 p-0">End Date : '.$end_date.'</p></div>
                          <div class="mb-3"><hr class="p-0 m-0"></div>
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
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <h5 class="m-0"><b>Request Number Of Employee : </b>'.$total.'</h5>
                                <h5 class="m-0"><b>Accepted Number Of Employee : </b>'.$c_total.'</h5>
                                <div class="bg-success text-white rounded p-1 bulkmessage" data-id="'.$value['id'].'" id="bulkmessage'.$k.'" style="display:none;">
                                <i class="mx-2 font-weight-bold pointer fa-brands fa-2x fa-whatsapp"></i>
                                </div>
        
                            </div>
                              <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                <li class="nav-item">
                                  <button type="button" class="nav-link active text-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home'.$k.'" aria-controls="navs-pills-justified-home'.$k.'" aria-selected="true">Regular &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-success regular_count'.$k.'">30</span></button>
                                </li>
                                <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile'.$k.'" aria-controls="navs-pills-justified-profile'.$k.'" aria-selected="false">Avilable &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-warning aveilable_count'.$k.'">30</span></button>
                                </li>
                                <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages'.$k.'" aria-controls="navs-pills-justified-messages'.$k.'" aria-selected="false">On Call &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-gray oncall_count'.$k.'">30</span></button>
                                </li>
                              </ul>
                            </div>
                              <div class="d-grid" style="overflow: auto">
                              <div class="row p-0 m-0">
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
                    $background = 'bg-warning';
                    $status = 'ON GOING';

                    $result['data'][] = '         <div class="col-lg-12 mt-3">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <p class="mx-2 p-0">Start Date : '.$start_date.'</p>
                                        <p class="mx-2 p-0">End Date : '.$end_date.'</p>
                                    </div>
                                    <div class="mb-3">
                                        <hr class="p-0 m-0">
                                    </div>
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
                                        <button class="btn btn-primary me-1 show_on_going_result" data-jobid="'.$value['id'].'"
                                            data-status="true" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#onGoing'.$k.'" aria-expanded="false"
                                            aria-controls="onGoing" data-tableid="'.$k.'">
                                            <i class="fa-solid fa-filter"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse" id="onGoing'.$k.'">
                                    <hr>
                                    <div class="p-3 mt-3">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <h5 class="m-0"><b>Request Number Of Employee : </b>'.$total.'</h5>
                                            <h5 class="m-0"><b>Accepted Number Of Employee : </b>'.$c_total.'</h5>
                                        </div>
        
                                        <div class="d-grid" style="overflow: auto">
                                            <div class="row p-0 m-0">
                                                <div class="col-md-12 col-xl-12">
                                                    <div class="nav-align-top mb-4">
        
                                                        <div class="tab-content border">
                                                            <div class="tab-pane fade show active"
                                                                id="navs-pills-justified-home'.$k.'" role="tabpanel">
                                                                <div class="table-responsive text-white">
                                                                    <table class="table" id="ongoing'.$k.'" cellspacing="0"
                                                                        width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>First Name</th>
                                                                                <th>Last Name</th>
                                                                                <th>Contact Number</th>
                                                                                <th>Job Status</th>
                                                                                <th>Time Sheet</th>
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
                    </div>
                </div>';
                  
                  //   $result['data'][] = '<div class="col-lg-12 mt-3"> 
                  //   <div class="col-12">
                  //     <div class="card mb-4">
                  //       <div class="card-body p-2">
                  //         <div class="row">
                  //           <div class="col-lg-3 col-md-3 my-2">
                  //             <h5 class="m-0">'.ucwords($status).'</h5>
                  //           </div>
                  //           <div class="col-lg-3 col-md-3 my-2 ">
                  //             <h5 class="m-0">'.ucwords($supervisor).'</h5>
                  //           </div>
                  //           <div class="col-lg-3 col-md-3 my-2 ">
                  //             <h5 class="m-0">'.ucwords($job).'</h5>
                  //           </div>
                  //           <div class="col-lg-2 col-md-2 my-2 text-center">
                  //             <span class="p-2 '.$background.' text-white rounded">'.$status.'</span>
                  //           </div>
                  //           <div class="col-lg-1 col-md-1 text-center">
                  //             <button class="btn btn-primary me-1" data-status="" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$k.'" aria-expanded="false" aria-controls="collapseExample">
                  //               <i class="fa-solid fa-filter"></i> 
                  //             </button>
                  //           </div>
                  //         </div>
                  //         <div class="collapse" id="collapseExample'.$k.'">
                  //           <div class="d-grid d-sm-flex p-3 mt-3">
        
                  //           </div>
                  //         </div>
                  //       </div>
                  //     </div>
                  //   </div>
                  // </div>';

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
            $result['data'][] = ' <div class="text-center p-4 card">
                                No Result Found !
                              </div>';
            $result['success'] = false;
        }
        return $result;
    }

    public function regularDataTable(Request $request)
    {
        $message = SendMessage::where('job_request_id',$request->job_id)->pluck('message_status','employee_id')->toArray();
        $jobRequest = JobRequest::where('id',$request->job_id)->first();
        $allReadySent = SendMessage::where('job_request_id',$jobRequest->id)
          ->where('job_date',$jobRequest->job_date)->where('message_status','1')->pluck('employee_id')->toArray();
        $employee = Employee::whereNotIn('id',$allReadySent)->where('status','0')->where('job',$jobRequest->job_id);

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
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'" data-tableid="'.$request->table_id.'"></i></div>';
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
      $jobRequest = JobRequest::where('id',$request->job_id)->first();
      $allReadySent = SendMessage::where('job_request_id',$jobRequest->id)
      ->where('job_date',$jobRequest->job_date)->where('message_status','1')->pluck('employee_id')->toArray();
        $employee = Employee::whereNotIn('id',$allReadySent)->where('status','1')->where('job',$jobRequest->job_id);
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
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'" data-tableid="'.$request->table_id.'"></i></div>';
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
      $jobRequest = JobRequest::where('id',$request->job_id)->first();
      $allReadySent = SendMessage::where('job_request_id',$jobRequest->id)
      ->where('job_date',$jobRequest->job_date)->where('message_status','1')->pluck('employee_id')->toArray();
        $employee = Employee::whereNotIn('id',$allReadySent)->where('status','5')->where('job',$jobRequest->job_id);
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
            return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="regular_check" value="'.$row->id.'" data-jobid="'.$request->job_id.'" data-bulck="'.$request->table_id.'" /><i class="mx-2 send_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$row->id.'" data-jobid="'.$request->job_id.'" data-tableid="'.$request->table_id.'"></i></div>';
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

    public function onGoingJob(Request $request){

      $jobRequest = JobConfirmation::where('job_id',$request->job_id);
       
      return Datatables::of($jobRequest)
      ->rawColumns(['Job_Status'])
      ->addColumn('first_name', function($row)  {
       return $row->employee->first_name;       
      })
      ->addColumn('last_name', function($row)  {
        return $row->employee->last_name;       
       })
       ->addColumn('contact_number', function($row)  {
        return $row->employee->contact_number;       
       })
       ->addColumn('Job_Status', function($row)  {
          if($row->job_status == 0){
              return '<span class="badge bg-label-primary me-1">Pending</span>';
          }else if($row->job_status == 1){
              return '<span class="badge bg-label-warning me-1">On Going</span>';
          }else if($row->job_status == 2){
              return '<span class="badge bg-label-success me-1">Completed</span>';
          }       
       })
      ->addIndexColumn()->make(true);
    }

    public function sendMessageJob(Request $request){
      // dd($request->all());
        $job = JobRequest::where('id',$request->job_id)->first();
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        if($job){
            $message = SendMessage::where('employee_id',$request->employee_id)
            ->where('job_request_id',$job->id)
            ->whereDate('job_date',$job->job_date)->first();
            if($message){
                $data['success'] = true;
                $data['message'] = 'Message All Redy Been Send.';
            }else{
                $message_status = SendMessage::create([
                    'confirmation_id' => Str::random(30),
                    'employee_id' => $request->employee_id,
                    'job_request_id' => $job->id,
                    'job_date' => $job->job_date
                ]);
                $message_data = SendMessage::with('employee')->where('id',$message_status->id)
                  ->first()->toArray();

                $first_name =  $message_data['employee']['first_name'];
                $last_name =  $message_data['employee']['last_name'];
                
                $message = "Hello $first_name $last_name , \n";
                $message .= "Here's an interesting job that we think might be relevant for you. \n";
                $message .= "Please confirm your job below given link. \n";
                $message .= route('confirm_job',$message_data['confirmation_id']);

                $number = '+'.$message_data['employee']['countryCode'].$message_data['employee']['contact_number'];

                $send_message = sendMessage($number,$message);

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
                  $message_status = SendMessage::create([
                    'confirmation_id' => Str::random(30),
                    'employee_id' => $value,
                    'job_request_id' => $job->id,
                    'job_date' => $job->job_date
                  ]);

                  $message_data = SendMessage::with('employee')->where('id',$message_status->id)
                  ->first()->toArray();

                  $first_name =  $message_data['employee']['first_name'];
                  $last_name =  $message_data['employee']['last_name'];
                  
                  $message = "Hello $first_name $last_name , \n";
                  $message .= "Here's an interesting job that we think might be relevant for you. \n";
                  $message .= "Please confirm your job below given link. \n";
                  $message .= route('confirm_job',$message_data['confirmation_id']);

                  $number = '+'.$message_data['employee']['countryCode'].$message_data['employee']['contact_number'];

                  $send_message = sendMessage($number,$message);

                  if($send_message){
                    SendMessage::where('id',$message_data['id'])
                      ->update([
                        'message_status' => '1'
                      ]);
                  }else{
                    SendMessage::where('id',$message_data['id'])
                      ->update([
                        'message_status' => '2'
                      ]);
                  }

                }
            }
            $data['success'] = true;
            $data['message'] = 'Message Has Been Sent successfully.';
        }
        return $data;
    }

    public function employeeaCount(Request $request){
      $job = JobRequest::where('id',$request->job_id)->first();
      $allReadySent = SendMessage::where('job_request_id',$job->id)
      ->where('job_date',$job->job_date)->where('message_status','1')->pluck('employee_id')->toArray();
      $regular = Employee::whereNotIn('id',$allReadySent)->where('status','0')->where('job',$job->job_id)->count();
      $available = Employee::whereNotIn('id',$allReadySent)->where('status','1')->where('job',$job->job_id)->count();
      $oncall = Employee::whereNotIn('id',$allReadySent)->where('status','5')->where('job',$job->job_id)->count();
      return [
        'regular' => $regular,
        'available' => $available,
        'oncall' => $oncall,
      ];
    }
}
