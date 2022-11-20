@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
<style>
  thead{
      background: #152d47 !important;
      color: white !important;
      margin-top: 10px;
  }
  th{
    color: white !important;
  }
  .dataTables_filter{
      margin-bottom: 30px;
  }
  table{
    width: 100% !important;
  }
  </style>
@section('content')
    <div>
        <div class="col-lg-12 mb-3">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">JOB DETAILS</h5>
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" title="Filter" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-solid fa-filter"></i> 
                </button>
              </div>
              <div class="collapse mx-4" id="collapseExample">
                <div class="d-grid p-3">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="job_date" id="job_date" placeholder="xyz@gmail.com" aria-describedby="floatingInputHelp" />
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3">
                        <label for="date" class="form-label">Client</label>
                        <select id="client_name" name="client_name" class="form-select">
                            <option value="">Please select Client Name</option>
                            @foreach($client as $key => $value)
                                <option value="{{$value->client_name}}">{{$value->client_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3">
                        <label for="date" class="form-label">Supervisor</label>
                        <select id="supervisor" name="client_id" class="form-select">
                            <option value="">Please select Supervisor</option>
                          </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mt-2">
                        <br>
                          <button type="button" id="Search_result" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> </button>
                          <button type="button" id="Search_result_reset" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="" id="result_body">

          </div>
     
          {{-- <div class="col-lg-12 mt-3"> 
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-body p-2">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 my-2 text-center">
                      <h4 class="m-0">Yash</h4>
                    </div>
                    <div class="col-lg-3 col-md-3 my-2 text-center">
                      <h5 class="m-0">Dighpal Parmar</h5>
                    </div>
                    <div class="col-lg-3 col-md-3 my-2 text-center">
                      <h5 class="m-0">General Labor</h5>
                    </div>
                    <div class="col-lg-2 col-md-2 my-2 text-center">
                      <span class="p-2 bg-danger text-white rounded">ON GOING</span>
                    </div>
                    <div class="col-lg-1 col-md-1 text-center">
                      <button class="btn btn-primary me-1 show_result" data-status="true" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-filter"></i> 
                      </button>
                    </div>
                  </div>
                  <div class="collapse" id="collapseExample1">
                    <hr>
                    <div class="p-3 mt-3">
                      <div class="d-flex justify-content-between align-items-center">
                        <h5 class=""><b>Request Number Of Employee : </b>10</h5>
                        <div class="bg-success text-white rounded p-1 bulkmessage" data-id="5" id="bulkmessage1" style="display:none;">
                          <i class="mx-2 font-weight-bold pointer fa-brands fa-2x fa-whatsapp"></i>
                        </div>

                      </div>
                      <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                          <button type="button" class="nav-link active text-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">Regular &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-success">30</span></button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">Avilable &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-warning">30</span></button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false">On Call &nbsp;<span class="px-4 badge rounded-pill badge-center h-px-20 w-px-20 bg-gray">30</span></button>
                        </li>
                      </ul>
                    </div>
                      <div class="d-grid" style="overflow: auto">
                      <div class="row">
                        <div class="col-md-12 col-xl-12">
                          <div class="nav-align-top mb-4">
                       
                            <div class="tab-content border">
                              <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                                <div class="table-responsive text-white">
                                  <table class="table" id="dataTable1" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Action</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Contact Number</th>
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                <div class="table-responsive text-white">
                                  <table class="table" id="dataTable2" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Users</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                <div class="table-responsive text-white">
                                  <table class="table" id="dataTable3" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Users</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
          </div> --}}
  
    </div>
    <script src="{{asset("assets/js/custom/job_request_details.js")}}"></script>
@endsection

