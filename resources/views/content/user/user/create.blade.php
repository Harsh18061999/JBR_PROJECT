@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')
    <style>
        #countryCode-error {
            position: absolute;
            bottom: -28px;
        }
    </style>
    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class="p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3 class="text-center"><strong><i class="fa-solid fa-user mx-2"></i> User</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="user_from" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
                        novalidate>
                        @csrf
                        <div class="row mx-4">

                            <div class="col-md-6">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating error_message">
                                            <input autocomplete="" type="text" name="name" class="form-control" id="name"
                                                placeholder="John Smith" aria-describedby="floatingInputHelp"
                                                data-error="errNm1" />
                                            <label for="name">First Name</label>
                                        </div>
                                        <span id="errNm1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="xyz@gmail.com" aria-describedby="floatingInputHelp" />
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="form-floating">
                                    <select name="countryCode" id="countryCode" class="form-select chosen-select">
                                        <option value="">Please select</option>
                                        @foreach ($country as $k => $value)
                                            <option value="{{ $value->id }}">(+{{ $value->country_code }})
                                                {{ $value->name }}</option>
                                        @endforeach
                                       
                                    </select>
                                    <label for="countryCode">Country</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="contact_number"
                                                id="contact_number" placeholder="999666..."
                                                aria-describedby="contact_numberHelp" />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <select id="client_id" name="client_id" class="form-select">
                                                <option value="">Please select</option>
                                                @foreach ($client as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->client_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="client_id">Client</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" mb-2">
                                    <div class="">
                                        <div class="form-floating">
                                            <select class="form-select" name="role" required>
                                                <option value="">Select role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="">Role</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 text-center">
                                <button type="submit" class="btn btn-primary" id="user_button">ADD</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/user.js') }}"></script>
@endsection
