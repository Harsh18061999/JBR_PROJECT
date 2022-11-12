@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')
<style>
thead{
    background: #152d47;
    color: white;
    margin-top: 10px;
}
.dataTables_filter{
    margin-bottom: 30px;
}
.paginate_button  > .current{
  background-color: #696cff !important;
}
.harsh{
  width: 100%;
  height: 100%;
}
</style>
@section('content')
<div class="d-flex justify-content-between align-items-center">
   
</div>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i> 
            Employee</h5>
            <div class="d-flex">
                <div class="mx-2">
                    <a href="{{route('employee.create')}}" >
                        <button type="button" class="btn btn-primary" title="Add Employee">
                            <i class="fa-sharp fa-solid fa-user-plus mx-2"></i> 
                          </button>
                    </a>
                </div>
               
                <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" title="Filter" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-solid fa-filter"></i> 
                </button>
            </div>
        </div>
      <div class="card-body p-0">
        <div class="collapse" id="collapseExample">
          <div class="d-grid p-3">
            <div class="row">

                <div class="col-lg-3 mb-3">
                    <label for="employee_name" class="form-label">Employee</label>
                    <select class="form-select" name="employee_name" id="employee_name" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      @foreach ($employee as $item)
                        <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label for="job_title" class="form-label">JobCategory</label>
                    <select class="form-select" name="job_title" id="job_title" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      @foreach ($jobCategory as $item)
                        <option value="{{$item->id}}">{{$item->job_title}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      <option value="0">Regular</option>
                      <option value="1">Available</option>
                      <option value="2">Not Available</option>
                      <option value="3">Block</option>
                    </select>
                </div>
                <div class="col-lg-3 mt-2">
                    <br>
                      <button type="button" id="employee_search" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> </button>
                      <button type="button" id="employee_search_reset" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> </button>
                </div>
            </div>
          </div>
        </div>
        <div class="table-responsive text-nowrap p-2">
            {!! $dataTable->table(['class' => 'w-100'], true) !!}
            {{$dataTable->scripts()}}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-lg-3">
    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalScrollableTitle">Employee License</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="height: 100vh;">
            <iframe id="myFrame" style="width: 100%;height:100%;"></iframe>
            <img src="" alt="" id="my_img" style="display: block;width:100%;height:100%;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <a type="button" class="btn btn-primary" id="license_download" href="" target="_blank" download="pdfName">Download</a>
          </div> 
        </div>
      </div>
    </div>
  </div>
  
<script src="{{asset("assets/js/custom/employee.js")}}"></script>
@endsection

