
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
  #countryCode-error{
    position: absolute;
    bottom: -28px;
  }
</style>
<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong><i class="fa-solid fa-user mx-2"></i> User</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="user_from" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" novalidate> 
                  @csrf
                    <div class="row mx-3">

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="name" class="form-control" id="name" placeholder="John" value="{{$user->name}}" aria-describedby="floatingInputHelp" data-error="errNm1" />
                                  <label for="name">Name</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="email" name="email" class="form-control" id="email" placeholder="xyz@gmail.com" value="{{$user->email}}" aria-describedby="floatingInputHelp" data-error="errNm1" readonly/>
                                  <label for="email">Email Address</label>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <select class="form-control" name="role" required>
                                      <option value="">Select role</option>
                                      @foreach($roles as $role)
                                          <option value="{{ $role->id }}"
                                              {{ in_array($role->name, $userRole) 
                                                  ? 'selected'
                                                  : '' }}>{{ $role->name }}</option>
                                      @endforeach
                                  </select>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="user_button">ADD</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/user.js")}}"></script>
<script src="{{asset("assets/docsupport/jquery-3.2.1.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/chosen.jquery.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/docsupport/prism.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("assets/docsupport/init.js")}}" type="text/javascript" charset="utf-8"></script>

@endsection
