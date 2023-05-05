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
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <label for="job_date">RANGE</label>
                    <select class="form-select" name="custome_range" id="custome_range" aria-label="Default select example">
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

                @if ($role_name == 'admin')
                    <div class="col-lg-3 mb-3">
                        <label for="client_name" class="form-label">CLIENT</label>
                        <select class="form-select" name="client_name" id="client_name" aria-label="Default select example">
                            <option selected value="">Open this select menu</option>
                            @foreach ($client as $item)
                                <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-lg-3 mb-3">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <select class="form-select" name="supervisor" id="supervisor" aria-label="Default select example">
                        <option selected value="">Open this select menu</option>
                        @foreach ($supervisor as $item)
                            <option value="{{ $item->id }}">{{ $item->supervisor }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-lg-3 mb-3">
                    <label for="job_title" class="form-label">JobCategory</label>
                    <select class="form-select" name="job_title" id="job_title" aria-label="Default select example">
                        <option selected value="">Open this select menu</option>
                        @foreach ($jobCategory as $item)
                            <option value="{{ $item->id }}">{{ $item->job_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" aria-label="Default select example">
                        <option selected value="">Open this select menu</option>
                        <option value="0">PENDING</option>
                        <option value="1">ON GOING</option>
                        <option value="2">COMPLETED</option>
                    </select>
                </div> --}}
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
    {{-- <div class="card">
        <div class="table-responsive text-nowrap p-2">
            {!! $dataTable->table(['class' => 'w-100 table table-striped table-hover'], true) !!}
            {{ $dataTable->scripts() }}
        </div>
    </div> --}}
    <div class="card my-4">
        <div class="table-responsive p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Client</th>
                        <th scope="col">Supervisor</th>
                        <th scope="col">Employee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_data as $k => $item)
                        @foreach ($item as $key => $value)
                            <tr>
                                @if ($key == 0)
                                    <td rowspan="{{ count($item) }}">{{ $k }}</td>
                                @endif
                                <td>{{ $value['client_name'] ?? 'N/A' }}</td>
                                <td>{{ $value['supervisour'] ?? 'N/A' }} </td>
                                <td>
                                    @foreach($value['employee'] as $employee)
                                    <span class="badge bg-label-primary me-1 reallocate_job" data-bs-toggle="modal" data-bs-target="#modalCenter" data-employeeid="{{$employee['id']}}" data-id="{{$value['id']}}" data-date="{{$k}}">
                                        
                                        {{$employee['first_name']." ".$employee['last_name']}}<span class="text-danger ms-2 border border-danger rounded-circle" data-id=""><i class="fa-solid fa-xmark" style="cursor: pointer;padding:2px;"></i></span>
                                        <br>
                                        <br>
                                        {{$employee['contact_number']}}
                                    </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Reallocate Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="job_category_from" action="{{route('leave_request')}}" method="POST" enctype="multipart/form-data" novalidate> 
                        @csrf
                        <div class="row">
                            <input type="hidden" name="job_id" id="reallcate_job_id">
                            <input type="hidden" name="re_allocate_employee_id" id="re_allocate_employee_id">
                            <div class="col-md-12 mb-3">
                                <label for="reallocate_date" class="form-label">Date</label>
                                <input type="date"  class="form-control" readonly name="reallocate_date" id="reallocate_date">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="employee_available" class="form-label">Available Employee</label>
                                <select class="form-select" name="employee_available" id="employee_available" aria-label="Default select example">
                                    <option selected value="">Open this select menu</option>
                                </select>
                            </div>
                        </div>
                  
                        <div class="text-end">
                            <a  class="btn btn-outline-secondary hover_color" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    <script src="{{ asset('assets/js/custom/weekly.js') }}"></script>
@endsection
