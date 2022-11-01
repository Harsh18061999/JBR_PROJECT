$(document).ready(function(){

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z_ ]*$/i.test(value);
    }, "Letters only please"); 

    $("#job_category_from").validate({
        rules: {
            job_title : {
                required: true,
                lettersonly: true,
                minlength: 5
            }
        },
        messages : {
            job_title: {
                minlength: "JobCategory should be at least 5 characters."
            }
        },
        errorElement: "div",
        highlight: function(element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });

    $(".modal").on("hidden.bs.modal", function(){
        $('#job_category_from').trigger("reset");
    });

    var frm = $('#job_category_from');

    frm.submit(function (e) {

        e.preventDefault();

        var form = $('#job_category_from')[0];

        var data = new FormData(form);
        $.ajax({
            type: frm.attr('method'),
            enctype: 'multipart/form-data',
            url: frm.attr('action'),
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                if(data.success){
                    $('#modalCenter').modal('toggle');
                    swal("Success...", data.message, "success");
                    $('#job-category-table').DataTable().ajax.reload();
                }else{
                    swal("Oops...", data.error, "error"); 
                }
            },
            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);
            }
        });
    });

    $("body").on("click",".edit",function(){
        var url = $(this).attr('data-href');
        var update_url = $(this).attr('data-editurl');
        $.ajax({
            url: url,
            method: "get",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response.success){
                    $('#modalCenter').modal('toggle');
                    $("#job_title").val(response.data.job_title);
                    $("#job_category_from").attr("action",update_url);
                    if(response.data.license_status == 1){
                        $("#inlineRadio1").prop('checked',true);
                    }else{
                        $("#inlineRadio2").prop('checked',true);
                    }
                }else{
                    swal("Oops...", response.message, "error"); 
                }
            }
        });
    });

    $("body").on("click", '.delete', function() {
        var url = $(this).attr('data-href');
        deleteRecord(url);
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
                        swal("Poof! Your jobcategory has been deleted!", {
                            icon: "success",
                        });
                        $('#job-category-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your jobcategory is safe!");
            }
        });
    }
});