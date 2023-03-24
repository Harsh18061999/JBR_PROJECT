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
          <h4>Welcome to {{config('variables.templateName')}}!</h4>

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 error_div">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" autocomplete="off" id="email" name="email" placeholder="Enter your email or phone number" autofocus>
            </div>
            <div class="mb-3 form-password-toggle error_div">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                  {{-- <a href="">
                  <small>Forgot Password?</small>
                </a> --}}
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
  $.validator.addMethod("emailOrPhone", function(value, element){
      let re = /[A-Za-z]/g
      let no = /[0-9]/g
      if(value.match(no)){
        if(value.length < 10 && value.length > 10){
          return false;
        }
      }
      if(value.match(re)){
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
          
        return pattern.test(value);
      }
      return true;
    }, "please specify a valid email or phone number.");

    $("#formAuthentication").validate({
        rules: {
            email: {
                required: true,
                emailOrPhone: true
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
