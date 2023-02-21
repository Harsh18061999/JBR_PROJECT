$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    $("#Permission_from").validate({
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

    $("body").on("click","#permission_search",function(){
        $('#permission-table').DataTable().ajax.reload();
    });

    $("body").on("click","#permission_search_reset",function(){
        $("#permission_name").val('');
        $('#permission-table').DataTable().ajax.reload();
    });

    function deleteRecord(url) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this permission!",
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
                        swal("Poof! Your permission has been deleted!", {
                            icon: "success",
                        });
                        $('#permissions-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your permission is safe!");
            }
        });
    }

});