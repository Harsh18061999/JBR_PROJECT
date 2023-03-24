@extends('uselayouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
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
    <div class="card shadow-none bg-transparent" id="grad1">
        <div class="row mt-0 d-flex justify-content-center align-items-center">
            <div class="col-md-12">
                <div class=" p-0">
                    <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                        <img src="{{ asset('/assets/img/JBR_Staffing_Solutions.jpg') }}" class="m-auto" alt=""
                            width="250px" height="250px">
                        <h3 class="text-center"><strong>Onboarding Process</strong></h3>
                        <hr class="mt-4 mx-4">
                        <form id="sendOtp" action="{{ route('sendOtpEmployee') }}" method="POST" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mx-4 justify-content-center">
                                {{-- <input type="hidden" name="token_value" value="{{ $token }}"> --}}
                                <div class="col-md-12">
                                    <div class=" mb-4">
                                        <div class="">
                                            <div class="form-floating">
                                                <select class="form-select" name="countryCode" id="countryCode">
                                                    <option value="">Please select</option>
                                                    @foreach ($country_code as $k => $value)
                                                        <option value="{{ $value->id }}">(+{{ $value->country_code }})
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="countryCode">Country</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class=" mb-4">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="text" onkeypress="validate(event)" maxlength="10"
                                                    class="form-control" name="contact_number" id="contact_number"
                                                    placeholder="999666..." aria-describedby="contact_numberHelp" />
                                                <label for="contact_number">Contact Number</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2" id="resendOtp" data-token="{{ $token }}">
                                    <span class="btn btn-secondary mt-2 pt-2"><i
                                            class="fa-sharp fa-solid fa-rotate-right"></i></span>
                                </div> --}}
                                <div class="my-4 text-center">
                                    <button type="submit" class="btn btn-primary" id="employee_button">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
