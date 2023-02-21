@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="text-center p-0">
            <h3><strong><i class="fa-solid fa-user mx-2"></i>Edit Permission</strong></h3>
        </div>

        <div class="container mt-4">
            <form method="POST" id="permissionFrom" action="{{ route('permissions.update', $title) }}">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Title</label>
                    <input type="text" value="{{ $title }}" name="title"
                        class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="row" id="permission_div">
                    @foreach ($permissions as $k => $permission)
                        @if ($k == 0)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <div class="form-group">
                                            <label for="exampleInputName">Name</label>
                                            <input type="text" name="name[{{ $permission['id'] }}]"
                                                class="form-control" id="exampleInputName"
                                                placeholder="Enter name" value="{{$permission['name']}}">
                                        </div>
                                        <div class="form-group mx-4">
                                            <label for="exampleFormControlTextarea1">Sort
                                                Description</label>
                                            <textarea class="form-control" name="description[{{ $permission['id'] }}]" id="exampleFormControlTextarea1" rows="2">{{$permission['description']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="btn btn-sm btn-primary" id="more"
                                        data-id="{{ $last_id }}"><i
                                            class="fa-solid fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6" id="delete{{ $k }}">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <div class="form-group">
                                            <label for="exampleInputName">Name</label>
                                            <input type="text" name="name[{{ $permission['id'] }}]"
                                                class="form-control" id="exampleInputName"
                                                placeholder="Enter name" value="{{$permission['name']}}">
                                        </div>
                                        <div class="form-group mx-4">
                                            <label for="exampleFormControlTextarea1">Sort
                                                Description</label>
                                            <textarea class="form-control" name="description[{{ $permission['id'] }}]" id="exampleFormControlTextarea1" rows="2">{{$permission['description']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="btn btn-sm btn-danger less"
                                        data-id="{{ $k }}"><i
                                            class="fa-solid fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Update Permission</button>
                {{-- <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>                <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a> --}}
            </form>
        </div>

    </div>
    <script>
        $(function() {
            $('#permissionFrom').validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a name",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $("#permissionFrom").submit(function() {
                let submit = true;
                $.each($('#permissionFrom input'), function() {
                    if (!this.value) {
                        if (this.name != 'title') {
                            if (!$(this).hasClass('is-invalid')) {
                                $(this).addClass('is-invalid');
                                const error = document.createElement("span");
                                error.className = 'invalid-feedback';
                                error.innerText = 'this field is required';
                                $(this).parent().closest('.form-group').append(error);
                                submit = false;
                            }
                        }
                    }
                });
                $.each($('#permissionFrom textarea'), function() {
                    if (!this.value) {
                        if (this.name != 'title') {
                            if (!$(this).hasClass('is-invalid')) {
                                $(this).addClass('is-invalid');
                                const error = document.createElement("span");
                                error.className = 'invalid-feedback';
                                error.innerText = 'this field is required';
                                $(this).parent().closest('.form-group').append(error);
                                submit = false;
                            }
                        }
                    }
                });

                if(submit == false){

                    return false;
                }
            });
        });
        $("body").on("click", "#more", function() {
            const id = parseInt($(this).attr("data-id")) + 1;
            const div = `<div class="col-md-6" id="delete${id}">
                            <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <div class="form-group">
                                        <label for="exampleInputName">Name</label>
                                        <input type="text" name="name[${id}]" class="form-control"
                                            id="exampleInputName" placeholder="Enter name">
                                        </div>
                                        <div class="form-group mx-4">
                                            <label for="exampleFormControlTextarea1">Sort Description</label>
                                            <textarea class="form-control" name="description[${id}]" id="exampleFormControlTextarea1" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="btn btn-sm btn-danger less" data-id="${id}"><i class="fa-solid fa-minus"></i>
                                </div>
                            </div>
                        </div>`;
            $(this).attr('data-id', id);
            $("#permission_div").append(div);
        });
        $("body").on("click", ".less", function() {
            const id = $(this).attr("data-id");
            $("#delete" + id).remove();
        });
    </script>
@endsection