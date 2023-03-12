$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    $("#country_from").validate({
            rules: {
                country_id : {
                    required: true,
                },
                province_name: {
                    required: true,
                },
            },
            messages : {
                country_id: {
                    minlength: "Country is required."
                },
                province_name:{
                    minlength: "Province Code is required."
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

    $("body").on("click","#province_search",function(){
        $('#province-table').DataTable().ajax.reload();
    });

    $("body").on("click","#province_search_reset",function(){
        $("#name").val('');
        $('#province-table').DataTable().ajax.reload();
    });

    function deleteRecord(url) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
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
                        swal("Poof! Your province has been deleted!", {
                            icon: "success",
                        });
                        $('#province-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your province is safe!");
            }
        });
    }
   
});