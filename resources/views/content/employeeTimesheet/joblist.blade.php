@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
<style>
    thead {
        
        color:black;
        margin-top: 10px;
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
    .dataTables_scrollBody{
      min-height: 294px;
    }
    .dataTables_scrollFoot { display: none; }
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
                        Job Request Details</h5>
                <div class="d-flex">
                    <div class="mx-2">
                        <a href="{{ route('job_request.create') }}">
                            <button type="button" class="btn btn-primary" title="Add Job Request">
                                <i class="fa-sharp fa-solid fa-user-plus mx-2"></i>
                            </button>
                        </a>
                    </div>

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
                            <div  class="col-lg-3 mb-3">
                                <label for="job_date">RANGE</label>
                                <select class="form-select" name="custome_range" id="custome_range"
                                aria-label="Default select example">
                                <option value="1" selected>Current Week</option>
                                <option value="2">Previous Week</option>
                                <option value="3">Custome Range</option>
                                </select>
                            </div>
                    
                            <div class="col-lg-3 mb-3 select_date" style="display: none;">
                                <label for="job_date">JOB START DATE</label>
                                <input class="form-control" name="job_date" id="job_date" placeholder="yyyy-mm-dd"
                                    aria-describedby="floatingInputHelp" />
                            </div>
                            <div class="col-lg-3 mb-3 select_date" style="display: none;">
                                <label for="end_date">JOB END DATE</label>
                                <input class="form-control" name="end_date" required id="end_date" placeholder="yyyy-mm-dd"
                                    aria-describedby="floatingInputHelp" />
                            </div>
                        
                            @if($role_name == 'admin')
                            <div class="col-lg-3 mb-3">
                                <label for="client_name" class="form-label">CLIENT</label>
                                <select class="form-select" name="client_name" id="client_name"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    @foreach ($client as $item)
                                        <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <div class="col-lg-3 mb-3">
                                <label for="supervisor" class="form-label">Supervisor</label>
                                <select class="form-select" name="supervisor" id="supervisor"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    @foreach ($supervisor as $item)
                                        <option value="{{ $item->id }}">{{ $item->supervisor }}</option>
                                    @endforeach
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
                            <div class="col-lg-3 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="status"
                                    aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                    <option value="0">PENDING</option>
                                    <option value="1">ON GOING</option>
                                    <option value="2">COMPLETED</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <br>
                                <button type="button" id="job_search" class="btn btn-primary"><i
                                        class="fa-solid fa-magnifying-glass"></i> </button>
                                <button type="button" id="job_search_reset" class="btn btn-primary"><i
                                        class="fa-solid fa-arrows-rotate"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap p-2">
                    {!! $dataTable->table(['class' => 'w-100 table table-striped table-hover'], true) !!}
                    {{ $dataTable->scripts() }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/custom/emmployeeTimeSheet.js') }}"></script>
@endsection
