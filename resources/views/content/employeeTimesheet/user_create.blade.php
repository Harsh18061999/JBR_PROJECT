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
    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class="text-center p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3><strong><i class="fa-solid fa-user mx-2"></i> Uploade Time Sheet</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="employee_timesheet_from" action="{{ route('employee_timesheet.frontStore') }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mx-4">
                            <input type="hidden" name="time_sheet" id="" value="{{$time_sheet_status}}">
                          <input type="hidden" name="job_confirmations_id" id="" value="{{$job_details->id}}">
                            <div class="col-lg-4">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                value="{{ $job_details->employee->first_name . ' ' . $job_details->employee->last_name }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="first_name">Employee Name</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="client_name" class="form-control" id="client_name"
                                                value="{{ $job_details->job->client->client_name . ' ' . $job_details->employee->last_name }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
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
                                            <input type="text" name="supervisor" class="form-control" id="supervisor"
                                                value="{{ $job_details->job->client->client_name . ' ' . $job_details->employee->supervisor }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="supervisor">Supervisor</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="job_title" class="form-control" id="job_title"
                                                value="{{ $job_details->job->jobCategory->job_title . ' ' . $job_details->employee->last_name }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="job_title">Job Title</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="job_date" class="form-control" id="job_date"
                                                value="{{ $job_date }}" readonly aria-describedby="floatingInputHelp"
                                                data-error="errNm1" />
                                            <label for="job_date">Job date</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="p-2">

                                    <div class="row border">
                                        <label for="">Strat Time</label>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="start_hours" name="start_hours" class="form-select">
                                                    <option value=""></option>
                                                    <option value="1"> 1 </option>
                                                    <option value="2"> 2 </option>
                                                    <option value="3"> 3 </option>
                                                    <option value="4"> 4 </option>
                                                    <option value="5"> 5 </option>
                                                    <option value="6"> 6 </option>
                                                    <option value="7"> 7 </option>
                                                    <option value="8"> 8 </option>
                                                    <option value="9"> 9 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="11"> 11 </option>
                                                    <option value="12"> 12 </option>
                                                </select>
                                                <label for="start_hours">Hours</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="start_minutes" name="start_minutes" class="form-select">
                                                    <option value="00"> 00 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="20"> 20 </option>
                                                    <option value="30"> 30 </option>
                                                    <option value="40"> 40 </option>
                                                    <option value="50"> 50 </option>
                                                </select>
                                                <label for="start_minutes">Minutes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="start_day" name="start_day" class="form-select">
                                                    <option selected="" value="AM"> AM </option>
                                                    <option value="PM"> PM </option>
                                                </select>
                                                <label for="start_day">Meridiem</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="p-2">

                                    <div class="row border">
                                        <label for="" class="">End Time</label>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="end_hours" name="end_hours" class="form-select">
                                                    <option value=""></option>
                                                    <option value="1"> 1 </option>
                                                    <option value="2"> 2 </option>
                                                    <option value="3"> 3 </option>
                                                    <option value="4"> 4 </option>
                                                    <option value="5"> 5 </option>
                                                    <option value="6"> 6 </option>
                                                    <option value="7"> 7 </option>
                                                    <option value="8"> 8 </option>
                                                    <option value="9"> 9 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="11"> 11 </option>
                                                    <option value="12"> 12 </option>
                                                </select>
                                                <label for="end_hours">Hours</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="end_minutes" name="end_minutes" class="form-select">
                                                    <option value="00"> 00 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="20"> 20 </option>
                                                    <option value="30"> 30 </option>
                                                    <option value="40"> 40 </option>
                                                    <option value="50"> 50 </option>
                                                </select>
                                                <label for="end_minutes">Minutes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="end_day" name="end_day" class="form-select">
                                                    <option selected="" value="PM"> PM </option>
                                                    <option value="AM"> AM </option>
                                                </select>
                                                <label for="end_day">Meridiem</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label for="">Break Time</label>
                                <div class=" mb-4 mt-3">
                                    <div class="">
                                        <div class="form-floating">
                                            <select id="break_time" name="break_time" class="form-select">
                                                @for($i=0;$i<=60;$i++)
                                                <option value="{{$i}}"> {{$i}} </option>
                                                @endfor
                                            </select>
                                            <label for="break_time">Minutes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4">

                                <button type="submit" class="btn btn-primary" id="employee_button">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/employee_timesheet.js') }}"></script>
    <script src="{{ asset('assets/docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/docsupport/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('assets/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

@endsection
