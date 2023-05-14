@extends('layouts/contentNavbarLayout')
@section('title', 'Weekly scheduler')
<style>
    thead {
        background: #152d47;
        color: white;
        margin-top: 10px;
    }

    .table:not(.table-dark) th {
        color: white !important;
    }

    .dataTables_filter {
        margin-bottom: 30px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    .dataTables_scrollBody {
        min-height: 294px;
    }

    .dataTables_scrollFoot {
        display: none;
    }
</style>
<style type="text/css">
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
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i>
                    Weekly Scheduler</h5>
        </div>
        <form action="{{route("report.export")}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label for="job_date">RANGE</label>
                        <select class="form-select" name="custome_range" id="custome_range" aria-label="Default select example"
                            value="{{ $search['custome_range'] }}">
                            <option value="1" {{ $search['custome_range'] == 1 ? 'selected' : '' }}>Current Week</option>
                            <option value="2" {{ $search['custome_range'] == 2 ? 'selected' : '' }}>Previous Week</option>
                            <option value="3" {{ $search['custome_range'] == 3 ? 'selected' : '' }}>Custome Range</option>
                        </select>
                    </div>
    
                    <div class="col-lg-3 mb-3 select_date" style=" {{ $search['custome_range'] == 3 ? '' : 'display: none;' }}">
                        <label for="job_date">JOB START DATE</label>
                        <input class="form-control" name="job_date" value="{{ $search['job_date'] }}" id="job_date"
                            placeholder="yyyy-mm-dd" aria-describedby="floatingInputHelp" />
                    </div>
                    <div class="col-lg-3 mb-3 select_date" style="{{ $search['custome_range'] == 3 ?: 'display: none;' }}">
                        <label for="end_date">JOB END DATE</label>
                        <input value="{{ $search['end_date'] }}" class="form-control" name="end_date" required id="end_date"
                            placeholder="yyyy-mm-dd" aria-describedby="floatingInputHelp" />
                    </div>
    
                    @if ($role_name == 'admin')
                        <div class="col-lg-3 mb-3">
                            <label for="client_name" class="form-label">CLIENT</label>
                            <select class="form-select" name="client_name" id="client_name" aria-label="Default select example">
                                <option selected value="">Open this select menu</option>
                                @foreach ($client as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $search['client_name'] == $item->id ? 'selected' : '' }}>{{ $item->client_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="client_error"></span>
                        </div>
                    @endif
    
                    <div class="col-lg-3 mb-3">
                        <label for="supervisor" class="form-label">Supervisor</label>
                        <select class="form-select" name="supervisor" id="supervisor" aria-label="Default select example">
                            <option selected value="">Open this select menu</option>
                            @foreach ($supervisor as $item)
                                <option value="{{ $item->id }}"
                                    {{ $search['supervisor'] == $item->id ? 'selected' : '' }}>{{ $item->supervisor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 d-flex justify-content-center align-items-center">
                        <button type="button" id="job_search" class="btn btn-primary me-4"><i
                                class="fa-solid fa-magnifying-glass" style="font-size: 25px;"></i> </button>
                                <div class="text-end mb-4">
                                    <br>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa-solid fa-file-excel"  style="font-size: 25px;"></i>
                                    </button>
                                </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
    <div class="card my-4">
        <div class="table-responsive p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Employee</th>
                        <th scope="col">Client</th>
                        <th scope="col">Supervisor</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">Break Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Over Time</th>
                        <th scope="col">Total</th>
                        <th scope="col">Time Sheet Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_data as $k => $item)
                        <tr>
                            <td>{{ $item['date'] }}</td>
                            <td>{{ $item['employee'] }}</td>
                            <td>{{ $item['client'] }}</td>
                            <td>{{ $item['Supervisor'] }}</td>
                            <td>{{ $item['start_time'] }}</td>
                            <td>{{ $item['break_time'] }}</td>
                            <td>{{ $item['end_time'] }}</td>
                            <td>{{ $item['ot_time'] }}</td>
                            <td>{{ $item['hours'] }}</td>
                            @if ($item['time_sheet'] == true)
                                <td class="text-center">Completed</td>
                            @else
                                @php
                                    $job = $item['value'];
                                @endphp
                                <td class="text-center">
                                    @if ($item['re_allocate'] == true)
                                        <span class="badge bg-label-primary pointer rounded p-2" title="Upload time sheet">
                                            <a
                                                href="{{ route('employee_timesheet.create', $job->id) . "?employee_id=$job->employee_id&job_id=$job->job_id" }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke-dasharray="64" stroke-dashoffset="64" stroke-width="2"
                                                            d="M13 3L19 9V21H5V3H13">
                                                            <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                dur="0.6s" values="64;0" />
                                                        </path>
                                                        <path stroke-dasharray="14" stroke-dashoffset="14"
                                                            d="M12.5 3V8.5H19">
                                                            <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                begin="0.7s" dur="0.2s" values="14;0" />
                                                        </path>
                                                        <g stroke-dasharray="8" stroke-dashoffset="8" stroke-width="2">
                                                            <path d="M9 14H15">
                                                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                    begin="1s" dur="0.2s" values="8;0" />
                                                            </path>
                                                            <path d="M12 11V17">
                                                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                    begin="1.2s" dur="0.2s" values="8;0" />
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>
                                        </span>
                                    @else
                                        <span class="badge bg-label-primary pointer rounded p-2"
                                            title="Upload time sheet">
                                            <a href="{{ route('employee_timesheet.create', $job->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke-dasharray="64" stroke-dashoffset="64"
                                                            stroke-width="2" d="M13 3L19 9V21H5V3H13">
                                                            <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                dur="0.6s" values="64;0" />
                                                        </path>
                                                        <path stroke-dasharray="14" stroke-dashoffset="14"
                                                            d="M12.5 3V8.5H19">
                                                            <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                begin="0.7s" dur="0.2s" values="14;0" />
                                                        </path>
                                                        <g stroke-dasharray="8" stroke-dashoffset="8" stroke-width="2">
                                                            <path d="M9 14H15">
                                                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                    begin="1s" dur="0.2s" values="8;0" />
                                                            </path>
                                                            <path d="M12 11V17">
                                                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                                                    begin="1.2s" dur="0.2s" values="8;0" />
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/report.js') }}"></script>
@endsection
