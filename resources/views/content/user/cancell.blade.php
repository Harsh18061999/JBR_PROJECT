@extends('uselayouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
<style>
    body{
        overflow: hidden;
    }
</style>
<div class="card shadow bg-transparent vh-100 d-flex justify-content-center  align-items-center overflow-hidden" id="grad1">
    <div class="row mt-0">
        <div class="col-md-12 m-auto text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h1>OOPS!</h1>
                {{-- <i class="fa-solid text-success fa-circle-check fa-5x"></i> --}}
                <i class="fa fa-times text-danger fa-5x" aria-hidden="true"></i>

               <h3 class="m-4">You have cancell this job! </h3>
            </div>
        </div>
    </div>
   
</div>