<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | Sneat - HTML Laravel Free Admin Template </title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  
  <!-- Include Styles -->
  @include('layouts/sections/styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')

  <script src="https://kit.fontawesome.com/fd19c82c98.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
</head>

<body>
 
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  {{-- remove while creating package --}}
  <!-- <div class="buy-now">
    <a href="{{config('variables.productPage')}}" target="_blank" class="btn btn-danger btn-buy-now">Upgrade To Pro</a>
  </div> -->
  {{-- remove while creating package end --}}

  <!-- Include Scripts -->
  @include('layouts/sections/scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <script>
      @if(Session::has('success'))
        swal("Success...", "{{ Session::get('success') }}", "success");
      @endif
      @if(Session::has('warning'))
        swal("Yikes...", "{{ Session::get('warning') }}", "warning");
      @endif
      @if(Session::has('error'))
        swal("Oops...", "{{ Session::get('error') }}", "error");
      @endif
  </script>
  {{-- <script src="{{asset('assets/js_file/jquery.validate.js')}}" type="text/javascript"></script> --}}
</body>

</html>
