
@extends('uselayouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <img src="{{asset('/assets/img/JBR_Staffing_Solutions.jpg')}}" class="m-auto" alt="" width="250px" height="250px">
                <h3><strong>JOB CONFIRMATION</strong></h3>
                <hr class="mt-4 mx-4">
                <div class="row">
                    <div class="col-lg-8 m-auto text-center">
                        <h4 class="">Hello <b>{{$message_data['employee']['first_name'].' '.$message_data['employee']['last_name']}}</b>,</h4>
                        <h4>Here's an interesting job that we think might be relevant for you.</h4>
                        <div class="d-flex justify-content-center">
                            <h5>Client Name : <b>{{$message_data['job_request']['supervisor']['client']['client_name']}}</b></h5>
                            <h5 class="mx-4">Address : <b>{{$message_data['job_request']['supervisor']['client']['client_address']}}</b></h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h5>Supervisor Name : <b>{{$message_data['job_request']['supervisor']['supervisor']}}</b></h5>
                            <h5 class="mx-4">Supervisor Address : <b>{{$message_data['job_request']['supervisor']['address']}}</b></h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h5>Start Date : {{$message_data['job_date']}}</h5>
                            <h5 class="mx-4">End Date : {{$message_data['job_request']['end_date']}}</h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h5>Strat Time : {{$message_data['job_request']['start_time']}}</h5>
                            <h5 class="mx-4">End Time : {{$message_data['job_request']['end_time']}}</h5>
                        </div>
                        <h5>Job Position : {{$message_data['employee']['job_category']['job_title']}}</h5>
                        <div class="row mb-4">
                            <div class="mx-auto col-lg-8 text-center my-2">
                                <div class="d-flex justify-content-center">
                                    <form method="POST" action="{{route('acceptJob')}}" id="acceptJobForm" class="mx-2">
                                        <input type="hidden" name="confirmation_id" value="{{$message_data['confirmation_id']}}">
                                        @csrf
                                        <input type="hidden" name="job_id" value="{{$message_data['job_request']['id']}}">
                                        <input type="hidden" name="employee_id" value="{{$message_data['employee']['id']}}">
                                        <input type="hidden" name="job_reallocate" id="" value="{{$message_data['is_reallocate']}}">
                                        <input type="hidden" name="job_date" value="{{$message_data['job_date']}}">
                                    </form>
                                    <button type="submit" id="acceptJob" class="btn btn-primary">ACCEPT</button>
                                    <form method="POST" action="{{route('cancellJob')}}" id="cancelJobForm" class="mx-2">
                                        <input type="hidden" name="confirmation_id" value="{{$message_data['confirmation_id']}}">
                                        @csrf
                                        <input type="hidden" name="job_id" value="{{$message_data['job_request']['id']}}">
                                        <input type="hidden" name="employee_id" value="{{$message_data['employee']['id']}}">
                                        <input type="hidden" name="job_reallocate" id="" value="{{$message_data['is_reallocate']}}">
                                    </form>
                                    <button type="submit" id="cancelJob" class="btn btn-danger">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function preventbackbutton() { window.history.forward(); }
    setTimeout("preventbackbutton()", 0);
    window.onunload = function () { null };

</script>
<script src="{{asset("assets/js/custom/job_confirm.js")}}"></script>

@endsection
<script>
function preventbackbutton() { window.history.forward(); }
    setTimeout("preventbackbutton()", 0);
    window.onunload = function () { null };

</script>

