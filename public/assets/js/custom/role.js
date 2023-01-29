$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    $("#Role_from").validate({
            rules: {
                name : {
                    required: true,
                    lettersonly: true,
                    minlength: 4
                },
            },
            messages : {
                name: {
                    minlength: "Name should be at least 4 characters."
                },
            },
            ignore: ":hidden:not(select)",
            errorElement: "div",
            highlight: function(element) {
                $(element).removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
            
    });

    $("body").on("click", '.delete', function() {
        var url = $(this).attr('data-href');
        deleteRecord(url);
    });

    $("body").on("click","#role_search",function(){
        $('#role-table').DataTable().ajax.reload();
    });

    $("body").on("click","#role_search_reset",function(){
        $("#role_name").val('');
        $('#role-table').DataTable().ajax.reload();
    });

    function deleteRecord(url) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this role!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        swal("Poof! Your role has been deleted!", {
                            icon: "success",
                        });
                        $('#role-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your role is safe!");
            }
        }); 
    }

});