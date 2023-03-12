
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
  #cityCode-error{
    position: absolute;
    bottom: -28px;
  }
</style>
<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i>City</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="city_from" action="{{route('city.store')}}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-4">

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <select id="provience_id" name="provience_id" class="form-select">
                                    <option value="">Please select</option>
                                    @foreach($province as $value)
                                      <option value="{{$value->id}}" data-license="{{$value->provience_name}}">{{$value->provience_name}}</option>
                                    @endforeach
                                  </select>
                                  <label for="provience_id">Province</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="city_title" id="city_title" placeholder="City" aria-describedby="floatingInputHelp" />
                                  <label for="city_title">City</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="city_button">ADD</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/city.js")}}"></script>
<script src="{{asset("assets/docsupport/jquery-3.2.1.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/chosen.jquery.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/prism.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("assets/docsupport/init.js")}}" type="text/javascript" charset="utf-8"></script>

@endsection

