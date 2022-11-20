$(document).ready(function(){
        
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    jQuery.validator.addMethod("phoneUS", function(contact_number, element) {
        contact_number = contact_number.replace(/\s+/g, "");
        return this.optional(element) || contact_number.length > 9 && 
        contact_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

    $.validator.addMethod("valueNotEquals", function(value, element){
        return value != '';
    }, "Please select field.");

    $("#employee_from").validate({
            rules: {
                first_name : {
                    required: true,
                    lettersonly: true,
                    minlength: 3
                },
                last_name: {
                    required: true,
                    lettersonly: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                contact_number:{
                    required:true,
                    phoneUS:true
                },
                date_of_birth:{
                    required:true
                },
                job: { valueNotEquals: true, }
            },
            messages : {
                first_name: {
                    minlength: "Name should be at least 3 characters."
                },
                last_name:{
                    minlength: "Last Name should be at least 3 characters."
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

    $("body").on("click", '.delete', function() {
        var url = $(this).attr('data-href');
        deleteRecord(url);
    });

    $("body").on("click","#employee_search",function(){
        $('#employee-table').DataTable().ajax.reload();
    });

    $("body").on("click","#employee_search_reset",function(){
        $("#employee_name").val('');
        $("#job_title").val('');
        $("#status").val('');
        $('#employee-table').DataTable().ajax.reload();
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
                        swal("Poof! Your employee has been deleted!", {
                            icon: "success",
                        });
                        $('#employee-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your employee is safe!");
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

    $("body").on("click",".license_view,#edit_license_view",function(){
        $('#modalScrollable').modal('toggle');
        var str =  $(this).attr('data-href');
        var test = (/\.(gif|jpg|jpeg|tiff|png)$/i).test(str)
        if(test){
            $("#my_img").attr("src",$(this).attr('data-href'));
            $("#my_img").css("display","block");
            $("#myFrame").css("display","none");
        }else{
            $("#myFrame").attr("src",$(this).attr('data-href'));
            $("#my_img").css("display","none");
            $("#myFrame").css("display","block");
        }
        $("#license_download").attr('href',$(this).attr('data-href'));
        $("#license_download").attr('download',$(this).attr('data-pdfname'));
    });

    $("body").on("change",".employee_status",function(){
        var select = $(this);
        var status = $(this).attr("data-status");
        var select_status = $(this).val();
        var select_status_text = $(this).find(":selected").text();;
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "You want to change employee status to "+select_status_text+".",
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
                        status:select_status
                    },
                    success: function(response) {
                        if(response.success){
                            swal("Status has been updated successfully.", {
                                icon: "success",
                            });
                            $('#employee-table').DataTable().ajax.reload(); 
                        }else{
                            swal("Oops...", response,message, "error");
                        }
                    }
                });
            } else {
                select.val(status);
              swal("Your employee is safe!");
            }
        });
    });

    // $("body").on("click",".unblock_employee",function(){
    //     var url = $(this).attr('data-href');
    //     swal({
    //         title: "Are you sure?",
    //         text: "You want to unblock this employee.",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     }).then((willDelete) => {
    //         if (willDelete) {
    //             $.ajax({
    //                 type: 'get',
    //                 url: url,
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 success: function(response) {
    //                     if(response.success){
    //                         swal(response.message, {
    //                             icon: "success",
    //                         });
    //                         $('#employee-table').DataTable().ajax.reload(); 
    //                     }else{
    //                         swal("Oops...", response,message, "error");
    //                     }
    //                 }
    //             });
    //         } else {
    //           swal("Your employee is safe!");
    //         }
    //     });
    // });
    $("body").on("change","#email",function(){
        $.ajax({
            type: 'get',
            url: '/employee_mail_check',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                email:$(this).val()
            },
            success: function(response) {
                if(response.success){
                    swal("Oops...", "Email Address Has All Ready Been Taken.", "error");
                    $("#email").val('');
                }
            }
        });
    });
    $("body").on("change","#contact_number",function(){
        $.ajax({
            type: 'get',
            url: '/employee_contact_check',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                contact_number:$(this).val()
            },
            success: function(response) {
                if(response.success){
                    swal("Oops...", "Contact Number Is All Redy Register.", "error");
                    $("#email").val('');
                }
            }
        });
    });

    $("body").on("change","#country",function(){
        $("#Provience").html('');
        $("#Provience").append(`<option value="">Please select Provience</option>`);
        $.ajax({
            type: 'get',
            url: '/get_provience',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                country_id:$(this).val()
            },
            success: function(response) {
                $.each(response, function(key, value) {
                    $("#Provience").append($('<option>', { value: value.id, text: value.provience_name }));
                });
            }
        });
    });

    $("body").on("change","#Provience",function(){
        $("#city").html('');
        $("#city").append(`<option value="">Please select city</option>`);
        $.ajax({
            type: 'get',
            url: '/get_city',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                provience_id:$(this).val()
            },
            success: function(response) {
                $.each(response, function(key, value) {
                    $("#city").append($('<option>', { value: value.id, text: value.city_title }));
                });
            }
        });
    });

    $("body").on("change","#data_contact_number",function(){
        $.ajax({
            type: 'get',
            url: '/get_employee',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                contact_number:$(this).val()
            },
            success: function(response) {
                if(response.success){
                    $("#employee_id").val(response.employee.id);
                    $("#first_name").val(response.employee.first_name);
                    $("#last_name").val(response.employee.last_name);
                }else{
                    swal("Oops...", "Contact Number Is Invalid.", "error");
                }
            }
        });
    });
});