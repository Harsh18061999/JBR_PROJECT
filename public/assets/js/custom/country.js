$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    $("#country_from").validate({
            rules: {
                name : {
                    required: true,
                },
                country_code: {
                    required: true,
                },
            },
            messages : {
                name: {
                    minlength: "Name is required."
                },
                country_code:{
                    minlength: "Country Code is required."
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
        alert(1);
        var url = $(this).attr('data-href');
        deleteRecord(url);
    });

    $("body").on("click","#country_search",function(){
        $('#country-table').DataTable().ajax.reload();
    });

    $("body").on("click","#country_search_reset",function(){
        $("#name").val('');
        $('#country-table').DataTable().ajax.reload();
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
                        swal("Poof! Your country has been deleted!", {
                            icon: "success",
                        });
                        $('#country-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your country is safe!");
            }
        });
    }
   
});