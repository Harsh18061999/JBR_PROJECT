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

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('passwordConfirm') }}">
            @csrf
            <input type="hidden" name="user_token" id="" value="{{$token}}">
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
