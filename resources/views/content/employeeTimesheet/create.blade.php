@extends('layouts/contentNavbarLayout')

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
            <div class="p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3 class="text-center"><strong><i class="fa-solid fa-user mx-2"></i> Employee Time Sheet</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="employee_timesheet_from" action="{{ route('employee_timesheet.store') }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mx-4">
                            <input type="hidden" name="time_sheet" id="" value="{{$time_sheet_status}}">
                            <input type="hidden" name="job_reallocate" value="{{$reallocate}}">
                            <input type="hidden" name="employee_id" value="{{$job_details->employee_id}}">
                            <input type="hidden" name="job_id" value="{{$job_details->job_id}}">
                          <input type="hidden" name="job_confirmations_id" id="" value="{{$job_details->id}}">
                            <div class="col-lg-3">
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
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="client_name" class="form-control" id="client_name"
                                                value="{{ $job_details->job->supervisor->client->client_name }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="client_name">Client Name</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="supervisor" class="form-control" id="supervisor"
                                                value="{{ $job_details->job->supervisor->supervisor }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="supervisor">Supervisor</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="job_title" class="form-control" id="job_title"
                                                value="{{ $job_details->job->jobCategory->job_title }}"
                                                readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                            <label for="job_title">Job Title</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            @foreach ($all_date as $k =>  $date)
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input type="text" name="job_date[{{$k}}]" class="form-control" id="job_date"
                                                value="{{ $date }}" readonly aria-describedby="floatingInputHelp"
                                                data-error="errNm1" />
                                            <label for="job_date">Job date</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="form-floating error_message">
                                        <input type="time" class="form-control" name="start_time[{{$k}}]" id="start_time">
                                        <label for="job_date">Start Time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="form-floating error_message">
                                        <input type="text" class="form-control" name="break_time[{{$k}}]">
                                        <label for="job_date">Break Time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class=" mb-4">
                                    <div class="form-floating error_message">
                                        <input type="time" class="form-control" name="end_time[{{$k}}]" id="end_time">
                                        <label for="job_date">End Time</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-12 mb-3 license_div">
                                <label for="formFile" class="form-label text-start w-100" id="license_text">Upload
                                    Time Sheet</label>
                                <input class="form-control" type="file" name="time_sheet_image" id="time_sheet_image">
                            </div>
                            <div class="my-4 text-center">
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
