@extends('uselayouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/docsupport/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/docsupport/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/docsupport/chosen.css') }}">
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
    <div class="card shadow-none bg-transparent" id="grad1">
        <div class="row mt-0 d-flex justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="text-center p-0">
                    <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                        <img src="{{ asset('/assets/img/JBR_Staffing_Solutions.jpg') }}" class="m-auto" alt=""
                            width="250px" height="250px">
                        <h3><strong>Verifay Account</strong></h3>
                        <hr class="mt-4 mx-4">
                        <form id="verifyAccount" action="{{ route('verifyOtp') }}" method="POST" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mx-4 justify-content-center">
                                <input type="hidden" name="token_value" value="{{ $token }}">
                                <div class="col-md-6">
                                    <div class=" mb-4">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="text" class="form-control numeric" name="otp"
                                                    id="otp" placeholder="Doe" aria-describedby="floatingInputHelp"
                                                    data-error="errNm2" maxlength="6" />
                                                <label for="otp">Enter OTP</label>
                                            </div>
                                            <span id="errNm2"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" id="resendOtp" data-token="{{ $token }}">
                                    <span class="btn btn-secondary mt-2 pt-2"><i
                                            class="fa-sharp fa-solid fa-rotate-right"></i></span>
                                </div>
                                <div class="my-4">
                                    <button type="submit" class="btn btn-primary" id="employee_button">Verify</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/employee.js') }}"></script>
    <script src="{{ asset('assets/docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/docsupport/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('assets/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
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
        // $(window).bind("pageshow", function() {
        //     window.history.forward();
        // });
        // (function($) {
        //     window.history.forward();
        // })()
        window.history.forward();
        // window.history.pushState(null, null, window.location.href);
        //     window.onpopstate = function() {
        //         window.history.go(1);
        //     };
        // (function($) {
        //     window.history.pushState(null, null, window.location.href);
        //     window.onpopstate = function() {
        //         window.history.go(1);
        //     };
        // })()
    </script>
