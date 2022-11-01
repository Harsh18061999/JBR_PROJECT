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
   
</div>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i> 
            Client</h5>
            <div class="d-flex">
                <div class="mx-2">
                    <a href="{{route('client.create')}}">
                        <button type="button" class="btn btn-primary" title="Add Client">
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

                <div class="col-md-3 mb-3">
                    <label for="client_name" class="form-label">Client</label>
                    <select class="form-select" name="client_name" id="client_name" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      @foreach ($client as $item)
                        <option value="{{$item->id}}">{{$item->client_name}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <select class="form-select" name="supervisor" id="supervisor" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      @foreach ($client as $item)
                        <option value="{{$item->id}}">{{$item->supervisor}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="job_title" class="form-label">JobCategory</label>
                    <select class="form-select" name="job_title" id="job_title" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      @foreach ($jobCategory as $item)
                        <option value="{{$item->id}}">{{$item->job_title}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      <option value="1">Available</option>
                      <option value="2">Not Available</option>
                      <option value="3">Block</option>
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <br>
                      <button type="button" id="client_search" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> </button>
                      <button type="button" id="client_search_reset" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> </button>
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

<script src="{{asset("assets/js/custom/client.js")}}"></script>
@endsection

