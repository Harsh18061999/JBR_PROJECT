$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    $.validator.addMethod("valueNotEquals", function(value, element){
        return value != '' && value != null;
    }, "Please select field.");

    $("#user_from").validate({
            rules: {
                name : {
                    required: true,
                    lettersonly: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                contact_number:{
                    required: true,
                },
                countryCode: { valueNotEquals: true, },
                client_id: { valueNotEquals: true, },
            },
            messages : {
                name: {
                    minlength: "Name should be at least 3 characters."
                },
                email:{
                    minlength: "Last Name should be at least 3 characters."
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

    $("body").on("click","#user_search",function(){
        $('#user-table').DataTable().ajax.reload();
    });

    $("body").on("click","#user_search_reset",function(){
        $("#user_name").val('');
        $("#status").val('');
        $('#user-table').DataTable().ajax.reload();
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
                        swal("Poof! Your user has been deleted!", {
                            icon: "success",
                        });
                        $('#user-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your user is safe!");
            }
        });
    }

    $("body").on("change","#job_category",function(){
        var option = $('option:selected', this).attr('data-license');
        var text = 'UPLOAD '+$('option:selected', this).text();
        if(option == 1){
            $(".license_div").css('display','block');
            // $("#license_text").html(text);
        }else{
            $(".license_div").css('display','none');
        }
    });

    $("body").on("change",".user_status",function(){
        var select = $(this);
        // var status = $(this).attr("data-status");
        var status = $(this).prop('checked') == true ? '1' : '0'; 
        var select_status = $(this).val();
        //var select_status_text = $(this).find(":selected").text();
        var select_status_text = status=='1'?'Active':'Inactive';
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "You want to change user status to "+select_status_text+".",
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
                    data:{
                        status:status
                    },
                    success: function(response) {
                        if(response.success){
                            swal("Status has been updated successfully.", {
                                icon: "success",
                            });
                            $('#user-table').DataTable().ajax.reload(); 
                        }else{
                            swal("Oops...", response,message, "error");
                        }
                    }
                });
            } else {
                select.val(status);
              swal("Your user is safe!");
            }
        });
    });

    $("body").on("change","#contact_number",function(){
        $("#employee_button").addClass("disabled");
        let countryCode = $("#countryCode").val();
        if(countryCode == '' || countryCode == null){
            swal("Oops...", "Please select countery code.", "error");
            $("#contact_number").val('');
            return false;
        }
        $.ajax({
            type: 'get',
            url: '/user_contact_check',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                contact_number:$(this).val(),
                countryCode: countryCode
            },
            success: function(response) {
                setTimeout(function(){
                    $("#employee_button").removeClass("disabled");
                },500);
                if(response.numberCheck == false){
                    swal("Oops...", "Given number is not whatsapp no.", "error");
                    $("#contact_number").val('');   
                }
                if(response.success){
                    swal("Oops...", "Contact number is all redy register.", "error");
                    $("#contact_number").val('');   
                }
            }
        });
    });

    
});