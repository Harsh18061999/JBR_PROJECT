@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style type="text/css">
        thead {
            background: #152d47;
            color: white;
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <style>
        .chosen-container {
            width: 100% !important;
            height: 100%;
        }

        .chosen-single {
            padding: 15px 0px 40px 0px !important;
            background: white !important;
        }

        .chosen-container div {
            padding: 15px 0px 0px 0px;
        }

        .chosen-container-single .chosen-drop {
            margin-top: -20px !important;
        }

        #countryCode-error {
            position: absolute;
            bottom: -28px;
        }
    </style>
    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class="p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3 class="text-center"><strong><i class="fa-solid fa-user mx-2"></i> Candidate Onboarding</strong></h3>
                    <hr class="mt-4 mx-4 mb-4">
                    <form id="employee_from" action="{{ route('employee.store') }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mx-4">

                            <div class="col-lg-6">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                placeholder="John" aria-describedby="floatingInputHelp"
                                                data-error="errNm1" />
                                            <label for="first_name">First Name</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                placeholder="Doe" aria-describedby="floatingInputHelp"
                                                data-error="errNm2" />
                                            <label for="last_name">Last Name</label>
                                        </div>
                                        <span id="errNm2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-floating">
                                    <select name="countryCode"  id="countryCode" class="form-select chosen-select">
                                        <option value="" >Please select</option>
                                        @foreach($country_code as $k => $value)
                                            <option value="{{$value->id}}">(+{{$value->country_code}}) {{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="countryCode">Country</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" onkeypress="validate(event)" maxlength="10" class="form-control" name="contact_number"
                                                id="contact_number" placeholder="999666..."
                                                aria-describedby="contact_numberHelp" />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="xyz@gmail.com" aria-describedby="floatingInputHelp" />
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class=" mb-4">
                                  <div class="">
                                      <div class="form-floating">
                                          <input type="text" required class="form-control" name="date_of_birth"
                                              id="date_of_birth" placeholder="yyyy-mm-dd"
                                              aria-describedby="floatingInputHelp" />
                                          <label for="date_of_birth">Date Of Birth</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            <div class="col-lg-6">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <select id="job_category" name="job" class="form-select">
                                                <option value="">Please select</option>
                                                @foreach ($jobCategory as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        data-license="{{ $value->license_status }}">{{ $value->job_title }}
                                                    </option>
                                                @endforeach
                                                {{-- <option value="General Labor">General Labor</option> --}}
                                            </select>
                                            <label for="job_category">Job Category</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 license_div" style="display: none;">
                                <label for="formFile" class="form-label text-start w-100" id="license_text">Upload
                                    License/Certificate</label>
                                <input class="form-control" type="file" name="lincense" id="formFile">
                            </div>
                            <p class="text-center">By clicking this button, you submit your information to the JBR Staffing Solutions, who will
                                use it to communicate with you regarding this event and their other services.</p>
                            <div class="my-4 text-center">

                                <button type="submit" class="btn btn-primary" id="employee_button">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/custom/employee.js') }}"></script>
    <script>
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
@endsection
