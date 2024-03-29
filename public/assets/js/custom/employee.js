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
        return value != '' && value != null;
    }, "Please select field.");

    $.validator.addMethod("isValidEmailAddress", function(value, element){
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(value);
    }, "Please enter valid email.");

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })

    var licence_status = $("#edit_license_view").attr("data-href");
    lincense_status = licence_status === undefined ? true : false;
    $.validator.addMethod("license_value", function(value, element){
        return lincense_status == true ? false : true;
    }, "Please select field.");

    $("#verifyAccount").validate({
        rules: {
            otp : {
                required : true,
                maxlength : 6
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

    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');
    });

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
                    isValidEmailAddress: true
                },
                contact_number:{
                    required: true,
                    // phoneUS:true
                },
                date_of_birth:{
                    required:true
                },
                lincense:{
                    license_value:true
                },
                job: { valueNotEquals: true, },
                countryCode: { valueNotEquals: true, },
            },
            messages : {
                first_name: {
                    minlength: "Name should be at least 3 characters."
                },
                last_name:{
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

    $("body").on("change",".license_div",function(){
        lincense_status = false;
    });

    $("body").on("change","#job_category",function(){
        var option = $('option:selected', this).attr('data-license');
        var text = 'UPLOAD '+$('option:selected', this).text();
        if(option == 1){
            lincense_status = true;
            $(".license_div").css('display','block');
            // $("#license_text").html(text);
        }else{
            lincense_status = false;
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
                    swal("Oops...", "Email Address Has Already Been Taken.", "error");
                    $("#email").val('');
                }
            }
        });
    });

    $("body").on("change","#countryCode",function(){
        let countryCode = $("#countryCode").val();
        let contact_number = $("#contact_number").val();
        if(contact_number != '' && contact_number != null){
            $.ajax({
                type: 'get',
                url: '/employee_contact_check',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    contact_number:contact_number,
                    countryCode: countryCode
                },
                success: function(response) {
                    if(response.numberCheck == false){
                        swal("Oops...", "Given number is not whatsapp no.", "error");
                        $("#contact_number").val('');   
                    }
                    if(response.success){
                        swal("Oops...", "Contact number is already register.", "error");
                        $("#contact_number").val('');   
                    }
                }
            });
        }
    });
    $("body").on("change","#contact_number",function(){
        $("#employee_button").addClass("disabled");
        let countryCode = $("#countryCode").val();
        if(countryCode == '' || countryCode == null){
            swal("Oops...", "Please select country code.", "error");
            $("#contact_number").val('');
            return false;
        }
        $.ajax({
            type: 'get',
            url: '/employee_contact_check',
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
                    swal("Oops...", "Contact number is already register.", "error");
                    $("#contact_number").val('');   
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
 $('#countryCode').val("22").trigger('chosen:refresh');
 $(".chosen-results li").each("")
 $(".chosen-results > li").each( function (i) {
        var value =$(this).text();
        $(this).addClass('result-selected');
    });
 $("#countryCode option:selected").text();
    $("body").on("click","#resendOtp",function(){
        var token = $(this).attr('data-token');
        $.ajax({
            type: 'POST',
            url: '/resend_otp',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                token:token
            },
            success: function (response) {
                if(!response.success){
                    swal("Oops...", "something went wrong", "error");
                }else{
                    swal(response.message);
                }
            },
            error: function (e) {
                swal("Oops...", "something went wrong", "error");
            }
        });
    });

    $("body").on("change","#otp",function(){
        var token = $("#token_value").val();
        var otp = $(this).val();
        $.ajax({
            type: 'get',
            url: '/verify_otp',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                token:token,
                otp:otp
            },
            success: function (response) {
                if(!response.success){
                    $("#otp").val('');
                    swal("Oops...",response.message , "error");
                }
            },
            error: function (e) {
                swal("Oops...", "something went wrong", "error");
            }
        });
    });

    $("#sendOtp").validate({
        rules: {
            countryCode : {
                valueNotEquals: true,
            },
            contact_number:{
                required : true
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
    
    $("#verifyAccount").validate({
        rules: {
            otp : {
                required: true,
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

    var maxBirthdayDate = new Date();

    maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18,11,31);
    var year = maxBirthdayDate.toLocaleString("default", { year: "numeric" });
    var month = maxBirthdayDate.toLocaleString("default", { month: "2-digit" });
    var day = maxBirthdayDate.toLocaleString("default", { day: "2-digit" });
    console.log(year,month,day)
    $("#date_of_birth").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-60:-18',
        maxDate: `${month}-${month}-${day}`,
        autoclose: true
    });

    if($('#date_of_birth').val() == ''){
        $('#date_of_birth').datepicker("setDate", `${month}-${month}-${day}` );
    }
    $("#countryCode").val($("#selected_contry_code").val());
    $("#contact_number").val($("#selected_phone_number").val());
});