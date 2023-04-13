@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
    .pointer :hover{
        cursor: pointer;
    }
</style>
    <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
        <div class="card invoice-preview-card">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                    <div class="mb-xl-0 mb-4">
                        <h3>{{ $jobReuest->supervisor->client->client_name }}</h3>
                        <div class="mb-2">
                            <span class="me-1">Address:</span>
                            <span class="fw-semibold">{{ $jobReuest->supervisor->client->client_address }}</span>
                        </div>
                    </div>
                    <div>
                        <h4>{{ $jobReuest->supervisor->supervisor }}</h4>
                        <div class="mb-2">
                            <span class="me-1">Address:</span>
                            <span class="fw-semibold">{{ $jobReuest->supervisor->address }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="me-1">Date Issues:</span>
                            <span class="fw-semibold">{{ $jobReuest->job_date }}</span>
                        </div>
                        <div>
                            <span class="me-1">Date Due:</span>
                            <span class="fw-semibold">{{ $jobReuest->end_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <h3 class="text-center"><svg style="margin-top: -5px;" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-dasharray="28" stroke-dashoffset="28"
                            stroke-linecap="round" stroke-width="2">
                            <path d="M4 21V20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="28;0" />
                            </path>
                            <path
                                d="M12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7C16 9.20914 14.2091 11 12 11Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.4s"
                                    values="28;0" />
                            </path>
                        </g>
                    </svg><strong> Employee List</strong></h3>
                {{-- <h4 class="text-center">Employee List & Time Sheet Status</h4> --}}
            </div>
            <div class="mx-4 mb-4 table-responsive">
                <table class="table  table-bordered border-top m-0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th class="text-center">Time Sheet & Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($employeeDetails->count() > 0)
                            @foreach ($employeeDetails as $job)
                                <tr>
                                    <td class="text-nowrap">{{ $job->employee->first_name . ' ' . $job->employee->last_name }}
                                    </td>
                                    <td class="text-nowrap">{{ $job->employee->email }}</td>
                                    <td>+{{ $job->employee->country->country_code . ' ' . $job->employee->contact_number }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-label-primary pointer rounded p-2" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample{{ $job->id }}" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2">
                                                    <rect width="16" height="16" x="4" y="4"
                                                        stroke-dasharray="64" stroke-dashoffset="64" rx="1">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            dur="0.5s" values="64;0" />
                                                    </rect>
                                                    <path stroke-dasharray="6" stroke-dashoffset="6" d="M7 4V2M17 4V2">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            begin="0.5s" dur="0.2s" values="6;0" />
                                                    </path>
                                                    <path stroke-dasharray="12" stroke-dashoffset="12" d="M7 11H17">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            begin="0.8s" dur="0.2s" values="12;0" />
                                                    </path>
                                                    <path stroke-dasharray="9" stroke-dashoffset="9" d="M7 15H14">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            begin="1s" dur="0.2s" values="9;0" />
                                                    </path>
                                                </g>
                                                <rect width="14" height="0" x="5" y="5"
                                                    fill="currentColor">
                                                    <animate fill="freeze" attributeName="height" begin="0.5s"
                                                        dur="0.2s" values="0;3" />
                                                </rect>
                                            </svg>


                                        </span>
                                        <span class="badge bg-label-success pointer rounded p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2">
                                                    <circle cx="12" cy="12" r="9" />
                                                    <path stroke-dasharray="14" stroke-dashoffset="14"
                                                        d="M8 12L11 15L16 10">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            dur="0.2s" values="14;0" />
                                                    </path>
                                                </g>
                                            </svg>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="collapse" id="collapseExample{{ $job->id }}" style="">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Start Time</th>
                                                            <th>Break Time</th>
                                                            <th>End Time</th>
                                                            <th>Total Hours</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($job->timeSheet->count() > 0)
                                                            @foreach ($job->timeSheet as $time)
                                                                <tr>
                                                                    <td>{{ $time->job_date }}</td>
                                                                    <td><input type="time" disabled id="start_time{{$time->id}}" name="appt" value="{{ $time->start_time }}">
                                                                        </td>
                                                                    <td><input type="text" style="width: 50%"  disabled id="break_time{{$time->id}}" name="appt" value="{{ $time->break_time }}"></td>
                                                                    <td><input type="time" disabled id="end_time{{$time->id}}" name="appt" value="{{ $time->end_time }}">
                                                                    </td>
                                                                    <td>
                                                                        {{-- @php
                                                                            $start_time = explode(':', $time->start_time);
                                                                            $end_time = explode(':', $time->end_time);
                                                                            
                                                                            $total_minutes = (int) ($end_time[1] - $start_time[1]);
                                                                            
                                                                            $break_time = $time->break_time;
                                                                            if ($end_time[2] == 'PM') {
                                                                                $end_hours = $end_time[0] + 12;
                                                                            } else {
                                                                                $end_hours = $end_time[0];
                                                                            }
                                                                            
                                                                            $total_hours = (int) ($end_hours - $start_time[0]) * 60;
                                                                            $total = ($total_hours - $break_time) / 60;
                                                                        @endphp --}}
                                                                        {{-- {{$total}} --}}
                                                                        10
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <span title="Edit" class="me-2 badge bg-label-primary pointer rounded p-2 edit_time_sheet" data-id="{{$time->id}}" id="edit{{$time->id}}">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-opacity="0" d="M20 7L17 4L8 13V16H11L20 7Z"><animate fill="freeze" attributeName="fill-opacity" begin="1.2s" dur="0.15s" values="0;0.3"/></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="20" stroke-dashoffset="20" d="M3 21H21"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="20;0"/></path><path stroke-dasharray="44" stroke-dashoffset="44" d="M7 17V13L17 3L21 7L11 17H7"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.6s" values="44;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M14 6L18 10"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1s" dur="0.2s" values="8;0"/></path></g></svg>
                                                                            </span> 
                                                                            <span title="Cancle" class="me-2 badge bg-label-danger pointer rounded p-2 cancle_time_sheet" data-id="{{$time->id}}" style="display:none" id="cancle{{$time->id}}">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"><path stroke-dasharray="60" stroke-dashoffset="60" d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.5s" values="60;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 12L16 16M12 12L8 8M12 12L8 16M12 12L16 8"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="8;0"/></path></g></svg>
                                                                            </span>
                                                                            <span title="Save" class="ml-2 badge bg-label-success pointer rounded p-2 save_time_sheet" data-id="{{$time->id}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><g stroke-width="2"><path stroke-dasharray="66" stroke-dashoffset="66" d="M12 3H19V21H5V3H12Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="66;0"/></path><path stroke-dasharray="10" stroke-dashoffset="10" d="M9 13L11 15L15 11"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1s" dur="0.2s" values="10;0"/></path></g><path stroke-dasharray="12" stroke-dashoffset="12" d="M14.5 3.5V6.5H9.5V3.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="12;0"/></path></g></svg></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr> 
                                                                <td colspan="6" class="text-center">No Record Found!!</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Results Found!!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/timesheetedit.js') }}"></script>

@endsection
