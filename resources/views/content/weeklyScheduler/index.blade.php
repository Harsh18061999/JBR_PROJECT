@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
<style>
    thead {
        background: #152d47;
        color: white;
        margin-top: 10px;
    }
    th{
        color: white !important;
    }
    .dataTables_filter {
        margin-bottom: 30px;
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
    <div class="d-flex justify-content-between align-items-center">

    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i>
                        Weekly Scheduler</h5>
                <div class="d-flex">
                    <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" title="Filter"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="collapse" id="collapseExample">
                    <div class="d-grid p-3">
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="client_name" class="form-label">Client</label>
                                <select class="form-select" name="client_name" id="client_name"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    @foreach ($client as $item)
                                        <option value="{{ $item->client_name }}">{{ $item->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="supervisor" class="form-label">Supervisor</label>
                                <select class="form-select" name="supervisor" id="supervisor"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    {{-- @foreach ($client as $item)
                                        <option value="{{ $item->id }}">{{ $item->supervisor }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="job_title" class="form-label">JobCategory</label>
                                <select class="form-select" name="job_title" id="job_title"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    @foreach ($jobCategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->job_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mt-2">
                                <br>
                                <button type="button" id="job_search" data-week="0" class="btn btn-primary"><i
                                        class="fa-solid fa-magnifying-glass"></i> </button>
                                <button type="button" id="job_search_reset" class="btn btn-primary"><i
                                        class="fa-solid fa-arrows-rotate"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <ul class="nav nav-pills m-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="current" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">Current Week</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="previous" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="false">Previous
                        week</button>
                </li>
            </ul>
            <div class="table-responsive p-2 text-white">
                <table class="table" id="weekly" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th style="width:60px;">Client Name</th>
                            <th  style="width:100px;">Supervisor Name</th>
                            <th>Employee</th>
                            <th style="width:30px;">Job Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/custom/weekly_scheduler.js') }}"></script>
@endsection
