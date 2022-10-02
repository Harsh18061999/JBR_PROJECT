@extends('layouts/blankLayout')

@section('title', 'Register Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center m-0">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <img src="{{asset('/assets/img/JBR_Staffing_Solutions.jpg')}}" class="m-auto" alt="" width="250px" height="250px">
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Adventure starts here 🚀</h4>
          <p class="mb-4">Make your app management easy and fun!</p>

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('register') }}">
          @csrf
            <div class="mb-3 error_div">
              <label for="name" class="form-label">Username</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" autofocus>
            </div>
            <div class="mb-3 error_div">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3 form-password-toggle error_div">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle error_div">
              <label class="form-label" for="password_confirmation">password_confirmation</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 ">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
            <button class="btn btn-primary d-grid w-100">
              Sign up
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{route('login')}}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
</div>
<script>
    jQuery.validator.addMethod("pwcheck", function(value) {
      if($('input[name="password_h"]').val()=='' && $('input[name="password"]').val()==''){
        return false;
      }else if($('input[name="password_h"]').val()=='' && $('input[name="password"]').val()!=''){
        return value.length >= 8 && /^(?=.*\d)(?=.*[A-Z])(?=.*\W).*$/i.test(value)
      }else if($('input[name="password_h"]').val()!='' && $('input[name="password"]').val()!=''){
        return value.length >= 8 && /^(?=.*\d)(?=.*[A-Z])(?=.*\W).*$/i.test(value)
      }else{
        return true;
      }
    }, 'Password must be 8 characters including 1 uppercase letter, 1 special character, numeric characters');
    $("#formAuthentication").validate({
        rules: {
          name: {
                required: true
            },
            email:{
              required: true,
              email: true
            },
            password:{
              required:true,
              pwcheck:true
            },
            password_confirmation: {
              required: true,
              equalTo: "#password"
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
