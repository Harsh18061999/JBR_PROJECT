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

    
    $.validator.addMethod("timeSelect", function(value, element){
        return value != '' && value != null;
    }, "Please select field.");

    $.validator.addMethod("valueNotEquals", function(value, element){
        return value != '';
    }, "Please select field.");

    $("#employee_timesheet_from").validate({
        rules: {
            start_hours: { timeSelect: true, },
            end_hours: { timeSelect: true, },
            start_minutes: { timeSelect: true, },
            end_minutes: { timeSelect: true, },
            start_day: { timeSelect: true, },
            end_day: { timeSelect: true, },
            break_time: { valueNotEquals: true, },
            email: {
                required: true,
                email: true
            },
            time_sheet_image:{required:true},
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

    $("#employee_timesheet_from").submit(function() {
        let submit = true;
        $.each($('#employee_timesheet_from input'), function() {
            if (!this.value) {
                // if (this.balue != 'title') {
                    if (!$(this).hasClass('is-invalid')) {
                        $(this).addClass('is-invalid');
                        const error = document.createElement("span");
                        error.className = 'invalid-feedback';
                        error.innerText = 'this field is required';
                        $(this).parent().closest('.form-floating').append(error);
                        submit = false;
                    }
                // }
            }
        });

        if (submit == false) {

            return false;
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

    
    $("body").on("change","#end_hours,#start_hours,#start_minutes,#end_minutes,#end_day,#start_day",function(){
        var start_hours = $("#start_hours").val();
        var end_hours = $("#end_hours").val();
        var start_minutes = $("#start_minutes").val();
        var end_minutes = $("#end_minutes").val();
        var start_day = $("#start_day").val();
        var end_day = $("#end_day").val();
        if(start_day == end_day){
            if(parseInt(start_hours) > parseInt(end_hours)  && end_hours != ''){
                swal("Oops...", "Please select valid hours", "error");
            }
            if(parseInt(start_minutes) > parseInt(end_minutes)){
                swal("Oops...", "Please select valid minutes", "error");
            }
        }
    });



});