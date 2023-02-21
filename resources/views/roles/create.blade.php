@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="text-center p-0">
            <h3><strong><i class="fa-solid fa-user mx-2"></i>Add Role</strong></h3>
        </div>
        <div class="container mt-4">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Name"
                        required>
                </div>

                {{-- <label for="permissions" class="form-label">Assign Permissions</label> --}}

                <table class="table table-striped">
                    {{-- <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th>
                    </thead> --}}
                    <div class="col-lg-12 my-2">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" class='permission' id="allPermission">
                            <label for="allPermission">
                                Assign Permissions
                            </label>
                        </div>
                    </div>
                    @foreach ($permissions_array as $key => $permission)
                        <section class="col-lg-12 my-2">
                            <div class="card direct-chat direct-chat-primary border border-primary">
                                <div class="card-header">
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" id="{{ $key }}" value="{{ $key }}"
                                            class="parent permission">
                                        <label for="{{ $key }}">{{ $key }}</label>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Conversations are loaded here -->
                                    <ul class="todo-list" data-widget="todo-list">


                                        @foreach ($permission as $k => $value)
                                            <!-- Message. Default to the left -->

                                            <li class="pl-4">
                                                <!-- checkbox -->
                                                <div class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" class="{{ $key }} permission child"
                                                        name="permission[{{ $value->name }}]" value="{{ $value->name }}"
                                                        data-class="{{ $key }}" name="todo1"
                                                        id="{{ $value->name . $k }}">
                                                    <label for="{{ $value->name . $k }}"></label>
                                                </div>
                                                <!-- todo text -->
                                                <span class="text">{{ $value->description }}</span>
                                                <!-- Emphasis label -->
                                                <small class="badge badge-secondary">{{ $value->name }}</small>
                                                <!-- General tools such as edit or delete-->

                                            </li>
                                        @endforeach

                                    </ul>

                                </div>

                            </div>
                        </section>
                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Save Role</button>
                {{-- <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a> --}}
            </form>
        </div>

    </div>
    <script>
        $(function() {
            $('#rolesFrom').validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a name",
                    }
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
        });

        $('body').on('change', '#allPermission', function() {
            if ($(this).is(':checked')) {
                $.each($('.permission'), function() {
                    $(this).prop('checked', true);
                    $(this).parent().closest('li').addClass('done');
                });
            } else {
                $.each($('.permission'), function() {
                    $(this).prop('checked', false);
                    $(this).parent().closest('li').removeClass('done');
                });
            }

        });

        $('body').on('change', '.parent', function() {
            let chield_ele = $(this).val();
            if ($(this).is(':checked')) {
                let chek_count = $('input.parent:checked').length;
                let all_count = $('input.parent').length;
                if (chek_count == all_count) {
                    $("#allPermission").prop('checked', true);
                }
                $.each($('.' + chield_ele), function() {
                    $(this).prop('checked', true);
                    $(this).parent().closest('li').addClass('done');
                });
            } else {
                $.each($('.' + chield_ele), function() {
                    $(this).prop('checked', false);
                    $(this).parent().closest('li').removeClass('done');
                });
                $("#allPermission").prop('checked', false);
            }
        });

        $('body').on('change', '.child', function() {
            let parent_ele = $(this).attr("data-class");
            if ($(this).is(':checked')) {
                let child_chek_count = $('input.' + parent_ele + ':checked').length;
                let child_all_count = $('input.' + parent_ele).length;
                if (child_chek_count == child_all_count) {
                    $("#" + parent_ele).prop('checked', true);
                }

                let chek_count = $('input.parent:checked').length;
                let all_count = $('input.parent').length;
                if (chek_count == all_count) {
                    $("#allPermission").prop('checked', true);
                }
            } else {
                $("#allPermission").prop('checked', false);
                $("#" + parent_ele).prop('checked', false);

            }
        });
    </script>
@endsection

@section('scripts')

@endsection
