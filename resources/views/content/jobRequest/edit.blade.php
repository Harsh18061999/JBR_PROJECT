
@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i> Update Job Request</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="job_request_form" action="{{route('job_request.update',$job_request->id)}}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-4">

                        <div class="col-lg-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                    <select id="client_name" name="client_name" class="form-select">
                                        <option value="">Please select Client Name</option>
                                        @foreach($client as $key => $value)
                                            <option value="{{$value->client_name}}" {{$value->client_name == strtoupper($client_selected->client_name) ? 'selected' : ''}}>{{$value->client_name}}</option>
                                        @endforeach
                                    </select>
                                  <label for="client_name">Client Name</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class=" mb-4">
                                <div class="">
                                  <div class="form-floating error_message">
                                    <select id="supervisor" name="client_id" class="form-select">
                                      <option value="">Please select Supervisor</option>
                                        @foreach($supervisor as $key => $value)
                                            <option value="{{$value->id}}" {{$value->id == $client_selected->id ? 'selected' : ''}}>{{$value->supervisor}}</option>
                                        @endforeach
                                    </select>
                                    <label for="supervisor">Supervisor</label>
                                  </div>
                                  <span id="errNm1"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                    <select id="job_category" name="job_id" class="form-select">
                                        <option value="">Please select</option>
                                        @foreach($jobCategory as $key => $value)
                                          <option value="{{$value->id}}" data-license="{{$value->license_status}}" {{$value->id == $job_request->job_id ? 'selected' : ''}}>{{$value->job_title}}</option>
                                        @endforeach
                                    </select>
                                    <label for="job_category">Job Category</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                          <div class=" mb-4">
                            <div class="">
                              <div class="form-floating">
                                <input type="date" class="form-control" name="job_date" id="job_date" placeholder="xyz@gmail.com" value="{{$job_request->job_date}}" aria-describedby="floatingInputHelp" />
                                  <label for="job_date">Hire Date</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class=" mb-4">
                            <div class="">
                              <div class="form-floating">
                                <input type="number" class="form-control" name="no_of_employee" id="no_of_employee" value="{{$job_request->no_of_employee}}" placeholder="Enter the no of employee to hire" aria-describedby="floatingInputHelp" />
                                  <label for="no_of_employee">NO Of Employee</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="employee_button">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/job_request.js")}}"></script>
<script>

</script>

@endsection

