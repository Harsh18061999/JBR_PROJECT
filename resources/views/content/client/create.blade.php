
@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i> Client Register</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="client_from" action="{{route('client.store')}}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-4">

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="client_name" class="form-control" id="client_name" placeholder="John" aria-describedby="floatingInputHelp" data-error="errNm1" />
                                  <label for="client_name">Client Name</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                                <div class="">
                                  <div class="form-floating error_message">
                                    <input type="text" name="supervisor" class="form-control" id="supervisor" placeholder="John" aria-describedby="floatingInputHelp" data-error="errNm1" />
                                    <label for="supervisor">Supervisor</label>
                                  </div>
                                  <span id="errNm1"></span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                    <select id="job_category" name="job" class="form-select">
                                        <option value="">Please select</option>
                                        @foreach($jobCategory as $key => $value)
                                          <option value="{{$value->id}}" data-license="{{$value->license_status}}">{{$value->job_title}}</option>
                                        @endforeach
                                    </select>
                                    <label for="job_category">Job Category</label>
                                </div>
                              </div>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="mb-4">
                                <div class="">
                                  <div class="form-floating">
                                    <textarea class="form-control" name="client_address" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <label for="floatingInput">Client Address</label>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <p>By clicking this button, you submit your information to the JBR Staffing Solutions, who will use it to communicate with you regarding this event and their other services.</p>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="employee_button">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/client.js")}}"></script>
<script>

</script>

@endsection

