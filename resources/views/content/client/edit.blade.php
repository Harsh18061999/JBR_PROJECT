@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

    <div class="card shadow bg-transparent" id="grad1">
        <div class="row mt-0">
            <div class=" p-0">
                <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                    <h3 class="text-center"><strong><i class="fa-solid fa-user mx-2"></i> Client Update</strong></h3>
                    <hr class="mt-4 mx-4">
                    <form id="client_from" action="{{ route('client.update', $client->id) }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mx-4">

                            <div class="col-lg-5 col-md-5">
                                <div class="form-floating error_message mb-2">
                                    <input type="text" name="client_name" value="{{ $client->client_name }}"
                                        class="form-control" id="client_name" placeholder="John"
                                        aria-describedby="floatingInputHelp" data-error="errNm1" />
                                    <label for="client_name">Client Name</label>
                                </div>
                                <span id="errNm1"></span> 
                            </div>

                            <div class="col-lg-7 col-md-7">
                                <div class="form-floating mb-2">
                                    <textarea class="form-control" name="client_address" id="exampleFormControlTextarea1" rows="3">{{ $client->client_address }}</textarea>
                                    <label for="floatingInput">Client Address</label>
                                </div>  
                            </div>
                            <div class="row p-0 m-0" id="permission_div">
                                @foreach ($supervisors as $k => $supervisor)
                                    @if ($k == 0)
                                        <div class="col-md-5 col-lg-5 form-floating error_message">
                                            <input type="text" name="supervisor[{{ $supervisor['id'] }}]"
                                            class="form-control" id="supervisor" placeholder="John"
                                            aria-describedby="floatingInputHelp" data-error="errNm1"
                                            value="{{ $supervisor['supervisor'] }}" />
                                            <label for="supervisor" style="padding-left: 24px;"> Supervisor <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-7 col-lg-7 form-group ">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="supervisor_address[{{ $supervisor['id'] }}]" id="supervisor_address" rows="5"
                                                cols="5">{{$supervisor['address']}}</textarea>
                                                <label for="floatingInput">Supervisor Address<span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                         
                                        <div class="col-md-5">
                                            <div class="mt-2">
                                                <div class="">
                                                    <div class="form-floating">
                                                        <select id="city1" name="city_id[{{ $supervisor['id'] }}]" class="form-select">
                                                            <option value="">Please select city </option>
                                                            @foreach ($city as $value)
                                                                <option value="{{ $value->id }}" {{$value->id == $supervisor['city_id'] ? 'selected' : ''}}>{{ $value->city_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="city">CITY <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <br>
                                            <div class="btn btn-sm btn-primary mx-2" id="more"
                                                data-id="{{ $last_id }}"><i class="fa-solid fa-plus"></i>
                                            </div>
                                        </div>
                                    @else
                                    <div class='row m-0 p-0 mt-2' id='delete{{$supervisor['id']}}'>
                                    <div class="mt-2 col-md-5 col-lg-5 form-floating error_message">
                                        <input type="text" name="supervisor[{{ $supervisor['id'] }}]"
                                        class="form-control" id="supervisor" placeholder="John"
                                        aria-describedby="floatingInputHelp" data-error="errNm1"
                                        value="{{ $supervisor['supervisor'] }}" />
                                        <label for="supervisor" style="padding-left: 24px;"> Supervisor <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="mt-2 col-md-7 col-lg-7 form-group ">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="supervisor_address[{{ $supervisor['id'] }}]" id="supervisor_address" rows="5"
                                            cols="5">{{$supervisor['address']}}</textarea>
                                            <label for="floatingInput">Supervisor Address<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                     
                                    <div class="col-md-5">
                                        <div class="mt-2">
                                            <div class="">
                                                <div class="form-floating">
                                                    <select id="city1" name="city_id[{{ $supervisor['id'] }}]" class="form-select">
                                                        <option value="">Please select city </option>
                                                        @foreach ($city as $value)
                                                            <option value="{{ $value->id }}" {{$value->id == $supervisor['city_id'] ? 'selected' : ''}}>{{ $value->city_title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="city">CITY <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <div class="mt-7 btn btn-sm btn-danger mx-2 less" 
                                            data-id="{{  $supervisor['id'] }}"><i class="fa-solid fa-minus"></i>
                                        </div>
                                    </div>
                                    </div>
                                    @endif
                                @endforeach
                               

                                
                            </div>
                            {{-- <div class="row" id="permission_div">
                                @foreach ($supervisors as $k => $supervisor)
                                    @if ($k == 0)
                                       
                                        
                                    @else
                                        <div class="col-md-12 mt-2" id="delete{{ $k }}">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="w-100 row">
                                                    <div class="col-md-6 my-2 form-floating error_message">
                                                        <input type="text" name="supervisor[{{ $supervisor['id'] }}]"
                                                            class="form-control" id="supervisor" placeholder="John"
                                                            aria-describedby="floatingInputHelp" data-error="errNm1"
                                                            value="{{ $supervisor['supervisor'] }}" />
                                                        <label for="supervisor">Supervisor</label>
                                                    </div>
                                                    <div class="col-md-6 my-2 form-group ">
                                                        <div class="form-floating">
                                                            <textarea class="form-control" name="supervisor_address[{{ $supervisor['id'] }}]" id="supervisor_address" rows="5"
                                                                cols="5">{{$supervisor['address']}}</textarea>
                                                            <label for="floatingInput">Supervisor Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn btn-sm btn-danger less mx-2" data-id="{{ $k }}">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div> --}}
                            <p class="text-center mt-4">By clicking this button, you submit your information to the JBR Staffing Solutions, who will
                                use it to communicate with you regarding this event and their other services.</p>
                            <div class="my-4 text-center">
                                <button type="submit" class="btn btn-primary" id="employee_button">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/client.js') }}"></script>
    <script>
        // $("body").on("click", "#more", function() {
        //     const id = parseInt($(this).attr("data-id")) + 1;
        //     const div = `<div class="col-md-12 mt-2" id="delete${id}">
        //                             <div class="d-flex align-items-center justify-content-center">
                                            
        //                                 <div class="w-100 row">
        //                                       <div class="col-md-6 my-2 form-floating error_message">
        //                                         <input type="text" name="supervisor[${id}]" class="form-control"
        //                                             id="supervisor" placeholder="John" aria-describedby="floatingInputHelp"
        //                                             data-error="errNm1" />
        //                                         <label for="supervisor">Supervisor</label>
        //                                     </div>
        //                                     <div class="col-md-6 my-2 form-group ">
        //                                         <div class="form-floating">
        //                                             <textarea class="form-control" name="supervisor_address[${id}]"  id="supervisor_address" rows="5" cols="5"></textarea>
        //                                             <label for="floatingInput">Supervisor Address</label>
        //                                         </div>
        //                                     </div>
        //                                 </div>
        //                                     <div class="btn btn-sm btn-danger less mx-2" data-id="${id}"><i class="fa-solid fa-minus"></i>
        //                                 </div>
        //                             </div>
        //                         </div>`;
        //     $(this).attr('data-id', id);
        //     $("#permission_div").append(div);
        // });
        // $("body").on("click", ".less", function() {
        //     const id = $(this).attr("data-id");
        //     $("#delete" + id).remove();
        // });
    </script>

@endsection
