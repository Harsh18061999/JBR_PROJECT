@extends('layouts/blankLayout')

@section('title', 'Login Page')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="">
  <div class="authentication-wrapper authentication-basic">
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center m-0">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <img src="{{asset('/assets/img/JBR_Staffing_Solutions.jpg')}}" class="m-auto" alt="" width="250px" height="250px">
            </a>
          </div>
          <h4>Welcome to {{config('variables.templateName')}}! 👋</h4>
          <p>Please sign-in to your account and start the adventure</p>

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 error_div">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle error_div">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                  <a href="">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
</div>

<script>
    $("#formAuthentication").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password:{
                required:true,
            }
        },
        messages : {
        },
        errorElement: "error_div",
        errorPlacement: function (error, element) {
          var placement = $(element).closest('.error_div');
          placement.append(error);
        },
        highlight: function(element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
            
    });
    @php
      $eroor_message = '';
      if ($errors->any()){
        foreach ($errors->all() as $error){
          $eroor_message .= $error;
        }
      }
    @endphp
    @if($eroor_message != '')
      swal("Oops...", "{{ $eroor_message }}", "error");
    @endif
    
</script>
@endsection
