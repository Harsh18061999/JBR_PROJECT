@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
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
@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i>
                        Campaign Link</h5>
            </div>
            <div class="m-4">
                <form id="campaign_from" action="{{ route('Campaign.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-lg-4">
                            <div class=" mb-4">
                                <div class="">
                                    <div class="form-floating">
                                        <input class="form-control" autocomplete="off" name="start_date" id="start_date"
                                            placeholder="yyyy-mm-dd" aria-describedby="floatingInputHelp" />
                                        <label for="start_date">Start Date</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class=" mb-4">
                                <div class="">
                                    <div class="form-floating"> 
                                        <input class="form-control" autocomplete="off" name="end_date" required id="end_date"
                                            placeholder="yyyy-mm-dd" aria-describedby="floatingInputHelp" />
                                        <label for="end_date">End Date</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <button type="submit" class="btn btn-primary" id="employee_button">Update Link</button>
                        </div>
                    </div>
                </form>
                <div class="border p-4">
                    <p>Currently Available Link  :  <a class="mx-4" id="link_url" href="{{route('employee_register')}}">{{route('employee_register')}}</a> <button class="btn btn-outline-primary" id="copyLink"><i class="fa-solid fa-copy"></i></button></p>
                    <p> Start Date : {{isset($link->start_date) ? $link->start_date : 'N/A'}}</p>
                    <p>End Date : {{isset($link->end_date) ? $link->end_date : 'N/A'}}</p>
                    @if($status == true)
                    <p>Status : <span class="badge bg-label-success">Active</span></p>
                    @else
                    <p>Status : <span class="badge bg-label-danger">In Active</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/custom/campaign.js') }}"></script>
    <script>

    </script>
@endsection
