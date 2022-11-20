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

    $("#data_entry_from").validate({
            rules: {
                contact_number : {
                    required: true,
                },
                sin: {
                    required: true,
                },
                line_1: {
                    required: true
                },
                line_2: {
                    required: true
                },  
                country: {
                    valueNotEquals: true
                },  
                provience: {
                    valueNotEquals: true
                },  
                city_id: {
                    valueNotEquals: true
                },  
                postal_code: {
                    required: true
                },  
                transit_number: {
                    required: true
                },
                institution_number: { required: true },
                account_number:{required:true},
                personal_identification:{required:true},
            },
            messages : {
               
            },
            
            errorElement: "div",
            highlight: function(element) {
                $(element).removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }  
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
        $("#city").html('');
        $("#city").append(`<option value="">Please select city</option>`);
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
                    $("#data_contact_number").val('');
                    swal("Oops...", "Contact Number Is Invalid.", "error");
                }
            }
        });
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
                        swal("Poof! Your data has been deleted!", {
                            icon: "success",
                        });
                        $('#data-entry-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your data is safe!");
            }
        });
    }
    
});