$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Letters only please"); 

    jQuery.validator.addMethod("phoneUS", function(contact_number, element) {
        contact_number = contact_number.replace(/\s+/g, "");
        return this.optional(element) || contact_number.length > 9 && 
        contact_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

    $.validator.addMethod("valueNotEquals", function(value, element){
        return value != '';
    }, "Please select field.");

    $("#client_from").validate({
            rules: {
                client_name : {
                    required: true,
                    minlength: 3
                },
                supervisor: {
                    required: true,
                    lettersonly: true,
                    minlength: 3
                },
                client_address: {
                    required: true
                },
                job: { valueNotEquals: true, }
            },
            messages : {
                client_name: {
                    minlength: "Client Name should be at least 3 characters."
                },
                supervisor:{
                    minlength: "Supervisor should be at least 3 characters."
                },
            },
            errorElement: "div",
            highlight: function(element) {
                $(element).removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
            
    });

    $("#client_from").submit(function() {
        let submit = true;
        $.each($('#client_from input'), function() {
            if (!this.value) {
                if (this.name != 'client_name') {
                    if (!$(this).hasClass('is-invalid')) {
                        $(this).addClass('is-invalid');
                        const error = document.createElement("span");
                        error.className = 'invalid-feedback';
                        error.innerText = 'this field is required';
                        $(this).parent().closest('.form-floating').append(error);
                        submit = false;
                    }
                }
            }
        });
        $.each($('#client_from select'), function() {
            if (!this.value) {
               
                if (!$(this).hasClass('is-invalid')) {
                    $(this).addClass('is-invalid');
                    const error = document.createElement("span");
                    error.className = 'invalid-feedback';
                    error.innerText = 'this field is required';
                    $(this).parent().closest('.form-floating').append(error);
                    submit = false;
                }
            
            }
        });
        $.each($('#client_from textarea'), function() {
            if (!this.value) {
                if (this.name != 'client_address') {
                    if (!$(this).hasClass('is-invalid')) {
                        $(this).addClass('is-invalid');
                        const error = document.createElement("span");
                        error.className = 'invalid-feedback';
                        error.innerText = 'this field is required';
                        $(this).parent().closest('.form-floating').append(error);
                        submit = false;
                    }
                }
            }
        });

        if(submit == false){

            return false;
        }
    });

    $("body").on("click", '.delete', function() {
        var url = $(this).attr('data-href');
        deleteRecord(url);
    });

    $("body").on("click","#client_search",function(){
        $('#client-table').DataTable().ajax.reload();
    });

    $("body").on("click","#client_search_reset",function(){
        $("#client_name").val('');
        $("#job_title").val('');
        $("#status").val('');
        $("#supervisor").val('');
        $('#client-table').DataTable().ajax.reload();
    });

    function deleteRecord(url) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        swal("Poof! Your client has been deleted!", {
                            icon: "success",
                        });
                        $('#client-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your client is safe!");
            }
        });
    }

    $("body").on("click",".block_client",function(){
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "You want to block this client.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success){
                            swal(response.message, {
                                icon: "success",
                            });
                            $('#client-table').DataTable().ajax.reload(); 
                        }else{
                            swal("Oops...", response,message, "error");
                        }
                    }
                });
            } else {
              swal("Your client is safe!");
            }
        });
    });

    $("body").on("click",".unblock_client",function(){
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "You want to unblock this client.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success){
                            swal(response.message, {
                                icon: "success",
                            });
                            $('#client-table').DataTable().ajax.reload(); 
                        }else{
                            swal("Oops...", response,message, "error");
                        }
                    }
                });
            } else {
              swal("Your client is safe!");
            }
        });
    });


    $("body").on("click","#more",function(){
        const id = parseInt($(this).attr("data-id")) + 1;
        $.ajax({
            type: 'get',
            url: '/add-more',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                provience_id:$(this).val(),
                key : id
            },
            success: function(response) {
                if(response.success){
                    $("#permission_div").append(response.div);
                    $("#more").attr('data-id',id);
                }
            }
        });
    });
    $("body").on("click", ".less", function() {
            const id = $(this).attr("data-id");
            $("#delete" + id).remove();
        });
});