@extends('uselayouts/contentNavbarLayout')

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
        #countryCode-error {
            position: absolute;
            bottom: -28px;
        }

        .container-p-y:not([class^=pb-]):not([class*=" pb-"]) {
            padding-bottom: 0px !important;
        }

        .container-p-y:not([class^=pt-]):not([class*=" pt-"]) {
            padding-top: 0px !important;
        }
    </style>
    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class="p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    {{-- <div class="d-flex"> --}}

                    <img src="{{ asset('/assets/img/JBR_Staffing_Solutions.jpg') }}" class="m-auto" alt=""
                        width="250px" height="250px">
                    {{-- <h2 class="fw-bold py-3 mb-4"> JBR Staffing Solutions
                    </h2> --}}
                    {{-- </div> --}}
                    <h3 class="text-center"><strong>Candidate Onboarding</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="employee_from" action="{{ route('employee_store') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="verify_token" id="verify_token" value="{{ $token_value->token }}">
                        <input type="hidden" name="selected_contry_code" id="selected_contry_code"
                            value="{{ $token_value->country_code }}">
                        <input type="hidden" name="selected_phone_number" id="selected_phone_number"
                            value="{{ $token_value->contact_number }}">
                        <div class="row mx-4">

                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-2 mb-2">
                                <div class="form-floating">
                                    <select name="countryCode" disabled id="countryCode" class="form-select chosen-select">
                                        <option value="">Please select</option>
                                        @foreach ($country_code as $k => $value)
                                            <option value="{{ $value->id }}">(+{{ $value->country_code }})
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="countryCode">Country</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" onkeypress="validate(event)" maxlength="10" readonly class="form-control"
                                                name="contact_number" id="contact_number" 
                                                placeholder="999666..." aria-describedby="contact_numberHelp" />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating">
                                            <select id="job_category" name="job" class="form-select">
                                                <option value="">Please select</option>
                                                @foreach ($jobCategory as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        data-license="{{ $value->license_status }}">
                                                        {{ $value->job_title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="job_category">Job Category</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 license_div" style="display: none;">
                                <label for="formFile" class="form-label text-start w-100" id="license_text">UPLOAD LICENSE/CERTIFICATE</label>
                                <input class="form-control" type="file" name="lincense" id="formFile">
                            </div>
                            <p class="text-center">By clicking this button, you submit your information to the JBR Staffing
                                Solutions, who will
                                use it to communicate with you regarding this event and their other services.</p>
                            <div class="my-4 text-center">

                                <button type="submit" class="btn btn-primary" id="employee_button">Register</button>
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
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/custom/employee.js') }}"></script>
    <script>
        @php
            $eroor_message = '';
            if ($errors->any()) {
                foreach ($errors->all() as $error) {
                    $eroor_message .= $error;
                }
            }
        @endphp
        @if ($eroor_message != '')
            swal("Oops...", "{{ $eroor_message }}", "error");
        @endif
    </script>
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
