
@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i> Candidate Onboarding</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="employee_from" action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-4">

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John" value="{{$employee->first_name}}" aria-describedby="floatingInputHelp" data-error="errNm1" />
                                  <label for="first_name">First Name</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Doe" value="{{$employee->last_name}}" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="last_name">Last Name</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="contact_number" id="floatingInput" value="{{$employee->contact_number}}" placeholder="999666..." aria-describedby="floatingInputHelp" />
                                  <label for="floatingInput">Contact Number</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="email" id="email" placeholder="xyz@gmail.com" value="{{$employee->email}}" aria-describedby="floatingInputHelp" />
                                  <label for="email">Email Address</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="date" value="{{$employee->date_of_birth}}" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="xyz@gmail.com" aria-describedby="floatingInputHelp" />
                                  <label for="date_of_birth">Date Of Birth</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                    <select id="job_category" name="job" class="form-select">
                                        <option value="">Please select</option>
                                        @foreach($jobCategory as $key => $value)
                                          <option value="{{$value->id}}" data-license="{{$value->license_status}}" {{$employee->jobCategory->id == $value->id ? 'selected' : ''}}>{{$value->job_title}}</option>
                                        @endforeach
                                      </select>
                                  <label for="job_category">Job Category</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 license_div" style="display: {{$employee->jobCategory->license_status == 1 ? 'block' : 'none'}};">
                          <label for="formFile" class="form-label text-start w-100" id="license_text">Upload License/Certificate</label>
                         
                          <div class="input-group mb-3 mt-3">
                            <input class="form-control" type="file" name="lincense" id="formFile">
                            @if($employee->lincense && $employee->lincense != '')
                            <div class="input-group-prepend">
                              <a class="btn btn-outline-secondary" id="edit_license_view" data-href="{{asset('storage/assets/'.$employee->lincense)}}" data-pdfname="{{$employee->first_name.'_'.$employee->last_name}}"><i class="p-1 fa-solid fa-eye"></i></a>
                            </div>
                            @endif
                          </div>
                        </div>
                        <p>By clicking this button, you submit your information to the JBR Staffing Solutions, who will use it to communicate with you regarding this event and their other services.</p>
                        <div class="my-4">

                            <button type="submit" class="btn btn-primary" id="employee_button">Update</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12 mx-4">
                        <form action="">
                            <div class="row">

                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-3">
  <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalScrollableTitle">Employee License</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="height: 100vh;">
          <iframe id="myFrame" style="width: 100%;height:100%;"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <a type="button" class="btn btn-primary" id="license_download" href="" target="_blank" download="pdfName">Download</a>
        </div> 
      </div>
    </div>
  </div>
</div>
<script src="{{asset("assets/js/custom/employee.js")}}"></script>

@endsection

