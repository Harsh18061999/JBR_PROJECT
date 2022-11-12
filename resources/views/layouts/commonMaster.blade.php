<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | JBR Staffing Solutions</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

  @include('layouts/sections/styles')
  @include('layouts/sections/scriptsIncludes')

  <script src="{{ asset('assets/appJs/fd19c82c98.js') }}" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
  <script src="{{ asset('assets/appJs/jquery.min.js') }}"></script>
  <script src = "{{ asset('assets/appJs/jquery.dataTables.min.js') }}" defer ></script>
  <script src="{{ asset('assets/appJs/sweetalert.min.js') }}"></script>
  
  <script src="{{ asset('assets/appJs/jquery.validate.min.js') }}"></script>
</head>
<body>
  @yield('layoutContent')
  @include('layouts/sections/scripts')
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
  <script src="{{ asset('assets/appJs/jquery.validate.min.js') }}"></script>
</body>
</html>
