
@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<link rel="stylesheet" href="{{asset("assets/docsupport/style.css")}}">
<link rel="stylesheet" href="{{asset("assets/docsupport/prism.css")}}">
<link rel="stylesheet" href="{{asset("assets/docsupport/chosen.css")}}">
<style>
  .chosen-container{
    width: 100% !important;
      height: 100%;
  }
  .chosen-single{
    padding: 15px 0px 40px 0px !important;
    background: white !important;
  }
  .chosen-container div{
    padding: 15px 0px 0px 0px;
  }
  .chosen-container-single .chosen-drop{
    margin-top:-20px !important;
  }
  #provinceCode-error{
    position: absolute;
    bottom: -28px;
  }
</style>
<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i> Province</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="province_from" action="{{ route('province.update', $province->id) }}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-3">

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">

                                  <select class="form-control" id="type" name="country_id">
                                    @foreach($country as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == $province->country_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                  </select> 

                                  <label for="country_id">Country</label>
                                </div>
                                <span id="errNm1"></span>
                                
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="provience_name" class="form-control" id="provience_name" placeholder="Province" value="{{$province->provience_name}}" aria-describedby="floatingInputHelp" data-error="errNm1"/>
                                  <label for="provience_name">Province</label>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="province_button">ADD</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/province.js")}}"></script>
<script src="{{asset("assets/docsupport/jquery-3.2.1.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/chosen.jquery.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/prism.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("assets/docsupport/init.js")}}" type="text/javascript" charset="utf-8"></script>

@endsection
