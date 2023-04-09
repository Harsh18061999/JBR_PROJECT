@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style type="text/css">
        thead {
            background: #152d47;
            color: white;
            margin-top: 10px;
        }

        .dataTables_filter {
            margin-bottom: 30px;
        }

        .ms-parent {
            padding: 0px;
            border: 0px solid #CED4DA;
        }

        .ms-choice>span.placeholder {
            color: #c9c8c8;
            padding: .4375rem .75rem;
        }

        .ms-choice {
            border: 1px solid #CED4DA;
        }

        tfoot {
            display: table-header-group;
        }

        .showDiv {
            display: inline-block !important;
        }

        .ui-datepicker-calendar td {
            padding: 0 !important;
        }

        .ui-datepicker-title select {
            display: inline-block;
        }

        .ui-datepicker select.ui-datepicker-month,
        .ui-datepicker select.ui-datepicker-year {
            width: 50% !important;
        }

        .ui-datepicker .ui-datepicker-prev {
            left: 2px !important;
            top: 9px !important;
        }

        .ui-datepicker .ui-datepicker-prev,
        .ui-datepicker .ui-datepicker-next {
            position: absolute !important;
            top: 8px !important;
            width: 1.8em !important;
            height: 1.8em !important;
        }

        .vrm {
            position: relative;
        }

        .searchIcon {
            position: absolute;
            right: 2px;
            top: 2px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .searchIcon i {
            color: #fff !important;
            margin-right: 0 !important;
        }

        .dataTables_length label {
            margin-left: 70px;
        }

        .chkLbl {
            padding-top: 3px;
            font-weight: normal;
            margin-left: 10px;
        }

        .searchfrom {
            float: left;
        }

        ::placeholder {
            /* Recent browsers */
            text-transform: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class="text-center p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3><strong><i class="fa-solid fa-user mx-2"></i> Update Job Request</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="job_request_form" action="{{ route('job_request.update', $job_request->id) }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mx-4">

                            <div class="col-lg-4">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <select id="client_name" name="client_name" class="form-select">
                                                <option value="">Please select Client Name</option>
                                                @foreach ($client as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == strtoupper($selected_supervisor->client_id) ? 'selected' : '' }}>
                                                        {{ $value->client_name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="client_name">Client Name</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <select id="supervisor" name="supervisor_id" class="form-select">
                                                <option value="">Please select Supervisor</option>
                                                @foreach ($supervisor as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $selected_supervisor->id ? 'selected' : '' }}>
                                                        {{ $value->supervisor }}</option>
                                                @endforeach
                                            </select>
                                            <label for="supervisor">Supervisor</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <select id="job_category" name="job_id" class="form-select">
                                                <option value="">Please select</option>
                                                @foreach ($jobCategory as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        data-license="{{ $value->license_status }}"
                                                        {{ $value->id == $job_request->job_id ? 'selected' : '' }}>
                                                        {{ $value->job_title }}</option>
                                                @endforeach
                                            </select>
                                            <label for="job_category">Job Category</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-4">
                          <div class=" mb-2">
                            <div class="">
                              <div class="form-floating">
                                <input type="date" class="form-control" name="job_date" id="job_date" placeholder="xyz@gmail.com" value="{{$job_request->job_date}}" aria-describedby="floatingInputHelp" />
                                  <label for="job_date">JOB Date</label>
                              </div>
                            </div>
                          </div>
                        </div> --}}

                            <div class="col-lg-4">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input class="form-control" value="{{ $job_request->job_date }}"
                                                name="job_date" id="job_date" placeholder="yyyy-mm-dd"
                                                aria-describedby="floatingInputHelp" />
                                            <label for="job_date">JOB Start Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input class="form-control" value="{{ $job_request->end_date }}"
                                                name="end_date" required id="end_date" placeholder="yyyy-mm-dd"
                                                aria-describedby="floatingInputHelp" />
                                            <label for="end_date">JOB End Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" value="{{ $job_request->hireperiod }}" name="hireperiod"
                                                id="hireperiod" placeholder="" class="form-control" required readonly />
                                            <label>Hire Period (Days)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-lg-6">
                                <div class="p-2">

                                    <div class="row">
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
                                                <input type="text"   onkeypress="validate(event)" name="start_minutes" id="start_minutes" placeholder=""
                                                class="form-control" required maxlength="2" />
                                                <label for="start_minutes">Minutes</label>
                                                {{-- <select id="start_minutes"  value={{$start_time[1]}} name="start_minutes" class="form-select">
                                                    <option value="00"> 00 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="20"> 20 </option>
                                                    <option value="30"> 30 </option>
                                                    <option value="40"> 40 </option>
                                                    <option value="50"> 50 </option>
                                                </select>
                                                <label for="start_minutes">Minutes</label> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="start_day"  value={{$start_time[2]}} name="start_day" class="form-select">
                                                    <option selected="" value="AM"> AM </option>
                                                    <option value="PM"> PM </option>
                                                </select>
                                                <label for="start_day">Meridiem</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-2">

                                    <div class="row">
                                        <label for="" class="">End Time</label>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="end_hours"  value={{$end_time[0]}} name="end_hours" class="form-select">
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
                                                <input type="text" onkeypress="validate(event)" name="end_minutes" id="end_minutes" placeholder=""
                                                class="form-control" required maxlength="2" />
                                                {{-- <select id="end_minutes"  value={{$end_time[1]}} name="end_minutes" class="form-select">
                                                    <option value="00"> 00 </option>
                                                    <option value="10"> 10 </option>
                                                    <option value="20"> 20 </option>
                                                    <option value="30"> 30 </option>
                                                    <option value="40"> 40 </option>
                                                    <option value="50"> 50 </option>
                                                </select> --}}
                                                <label for="end_minutes">Minutes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-floating error_message">
                                                <select id="end_day"  value={{$end_time[2]}} name="end_day" class="form-select">
                                                    <option selected="" value="PM"> PM </option>
                                                    <option value="AM"> AM </option>
                                                </select>
                                                <label for="end_day">Meridiem</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="no_of_employee"
                                                id="no_of_employee" value="{{ $job_request->no_of_employee }}"
                                                placeholder="Enter the number of employee to hire"
                                                aria-describedby="floatingInputHelp" />
                                            <label for="no_of_employee">Number Of Employee</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4">
                                <button type="submit" class="btn btn-primary" id="employee_button">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <input type="hidden" name="start_time_h" id="start_time_h" value="{{$start_time[0]}}">
        <input type="hidden" name="start_time_m" id="start_time_m" value="{{$start_time[1]}}">
        <input type="hidden" name="start_time_d" id="start_time_d" value="{{$start_time[2]}}">
        <input type="hidden" name="end_time_h" id="end_time_h" value="{{$end_time[0]}}">
        <input type="hidden" name="end_time_m" id="end_time_m" value="{{$end_time[1]}}">
        <input type="hidden" name="end_time_d" id="end_time_d" value="{{$end_time[2]}}">
    </div>
    <script src="{{ asset('assets/js/custom/job_request.js') }}"></script>
    <script>
    
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
        $("#start_hours").val($("#start_time_h").val())
        $("#start_minutes").val($("#start_time_m").val())
        $("#start_day").val($("#start_time_d").val())

        $("#end_hours").val($("#end_time_h").val())
        $("#end_minutes").val($("#end_time_m").val())
        $("#end_day").val($("#end_time_d").val())
    </script>

@endsection
