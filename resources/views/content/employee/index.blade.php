@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
<style>
thead{
    background: gray;
    color: white;
    margin-top: 10px;
}
.dataTables_filter{
    margin-bottom: 30px;
}
</style>
@section('content')
<div class="d-flex justify-content-between align-items-center">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i> Employee</h4>
    <div class="mb-4">
        <a href="{{route('employee.create')}}" class="btn btn-primary"><i class="fa-sharp fa-solid fa-user-plus mx-2"></i>Add Employee</a>
    </div>
</div>
<div class="card shadow bg-white">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {!! $dataTable->table(['class' => 'w-100'], true) !!}
        </div>
    </div>
</div>

{{$dataTable->scripts()}}
<script src="{{asset("assets/js/custom/employee.js")}}"></script>
@endsection

