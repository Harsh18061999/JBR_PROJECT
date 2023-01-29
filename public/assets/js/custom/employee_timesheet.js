$(document).ready(function(){
    var bulkmessage = [];
    $("body").on("change",".job_alert",function(){
        if(this.checked){
            if(!bulkmessage.includes($(this).val())){
                bulkmessage.push($(this).val());
            }
        }else{
            bulkmessage.splice(bulkmessage.indexOf($(this).val()),1);
        }
        if(bulkmessage.length > 0){
            $("#bulkmessage").css("display","block");
        }else{
            $("#bulkmessage").css("display","none");
        }
    });

    $("#employee_timesheet_from").validate({
        rules: {
            start_time : {
                required: true
            },
            break_time: {
                required: false,
            },
            email: {
                required: true,
                email: true
            },
            end_time:{
                required:true,
            }
        },
        messages : {

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

    $("body").on("click",".time_sheet_message",function(){
        var job_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: '/time_sheet_message_job',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_id:job_id
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

});