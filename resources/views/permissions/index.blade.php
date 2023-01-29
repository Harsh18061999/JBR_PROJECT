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

/* Status Toggle CSS */
/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
@section('content')
<div class="d-flex justify-content-between align-items-center">
   
</div>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <h5 class="m-0"><span class="text-muted fw-light"><i class="fa-sharp fa-solid fa-users mx-2"></i> 
            Permissions</h5>
            <div class="d-flex">
                <div class="mx-2">
                    <a href="{{route('permissions.create')}}" >
                        <button type="button" class="btn btn-primary" title="Add Permission">
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
                    <label for="role" class="form-label">Permission</label>
                    <select class="form-select" name="permission" id="permission" aria-label="Default select example">
                      <option selected value="">Open this select menu</option>
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                    </select>
                </div>
                <div class="col-lg-3 mt-2">
                    <br>
                      <button type="button" id="permission_search" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> </button>
                      <button type="button" id="permission_search_reset" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> </button>
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
            <h5 class="modal-title" id="modalScrollableTitle">User License</h5>
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
  
<script src="{{asset("assets/js/custom/permission.js")}}"></script>
@endsection

