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
.hover_color:hover{
    color: white !important;
}
</style>
@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i> JobCategory</h4>
    <div class="">
        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                <i class="fa-solid fa-circle-plus mx-2"></i> Add JobCategory
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Add JobCategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="job_category_from" action="{{route('job_category.store')}}" method="POST" enctype="multipart/form-data" novalidate> 
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="job_title" class="form-label">Job Title</label>
                                    <input type="text" name="job_title" id="job_title" class="form-control" placeholder="Enter Job Title">
                                </div>
                            </div>
                            <div class="row g-2 d-flex">
                                <div class="">
                                    <small class="fw-semibold d-block">Licence</small>
                                    <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="license_status" id="inlineRadio1" value="1" />
                                    <label class="form-check-label" for="inlineRadio1">Required</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="license_status" id="inlineRadio2" value="0" checked/>
                                    <label class="form-check-label" for="inlineRadio2">Not Required</label>
                                    </div>
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
        </div>
    </div>
</div>
<div class="card shadow bg-white">
    <div class="card-body">
        <div class="text-nowrap">
            {!! $dataTable->table(['class' => 'w-100'], true) !!}
        </div>
    </div>
</div>

{{$dataTable->scripts()}}
<script src="{{asset("assets/js/custom/jobcategory.js")}}"></script>
@endsection

