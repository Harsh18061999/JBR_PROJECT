$(document).ready(function(){

    $("body").on("change","#client_name",function(){
        $("#supervisor").html('');
        $("#supervisor").append(`<option value="">Please select Supervisor</option>`);
        $.ajax({
            type: 'GET',
            url: '/get_supervisor',
            data: {
                "_token": "{{ csrf_token() }}",
                client_id:$(this).val()
            },
            success: function (response) {
                if(response.success){
                    $.each(response.supervisor, function(key, value) {
                        $("#supervisor").append($('<option>', { value: value.id, text: value.supervisor }));
                    });
                }
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    });


    //form validation
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

    $.validator.addMethod("timeSelect", function(value, element){
        return value != '' && value != null;
    }, "Please select field.");

    $("#job_request_form").validate({
            rules: {
                client_name : {valueNotEquals: true},
                supervisor_id : {valueNotEquals: true},
                client_id: {valueNotEquals: true},
                job_id: { valueNotEquals: true, },
                start_time: { required: true, },
                end_time: { required: true, },
                job_date:{ required:true },
                no_of_employee:{ required:true }
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
                        swal("Poof! Your Job request has been deleted!", {
                            icon: "success",
                        });
                        $('#job-request-table').DataTable().ajax.reload();
                    }
                });
            } else {
              swal("Your Job is safe!");
            }
        });
    }


    $("#job_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        autoclose: true,
        onSelect: function() {
            var startdate = $('#job_date').datepicker('getDate');
            var end_date = $('#end_date').datepicker('getDate');
            if (!end_date || end_date < startdate) {
                var day = 60 * 60 * 24 * 1000;
                var end_date = new Date(startdate.getTime());
                $('#end_date').datepicker('setDate', end_date);
                // console.log(startdate.getDate() + '/' + (startdate.getMonth() + 1) + '/' + startdate
                //     .getFullYear());
                $('#end_date').datepicker({
                    minDate: new Date(),
                });
            }
            $('#end_date').datepicker('option', 'minDate', new Date(startdate));
            var countDays = parseInt(Math.round(($('#end_date').datepicker('getDate') - startdate) / (1000 *
                60 * 60 * 24)));
            console.log(countDays);
            countDays = (countDays > 0) ? countDays + 1 : 1;
            $('#hireperiod').val(countDays);
            this.focus();
            $('#end_date').focus();
            $('#hireperiod').focus();
            $('#hireperiod').focusout();
        },
        onClose: function() {
            this.blur();
        },
    });

    $("#end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        autoclose: true,
        onSelect: function() {
            var end_date = $('#end_date').datepicker('getDate');
            var startdate = $('#job_date').datepicker('getDate');
            if (startdate) {} else {
                var day = 60 * 60 * 24 * 1000;
                var startdate = new Date(end_date.getTime());
                $('#job_date').datepicker('setDate', startdate);
                $('#end_date').datepicker('option', 'minDate', new Date(startdate));
            }
            var countDays = parseInt(Math.round((end_date - startdate) / (1000 * 60 * 60 * 24)));
            countDays = (countDays > 0) ? countDays + 1 : 1;
            $('#hireperiod').val(countDays);
            this.focus();
            $('#hireperiod').focus();
            $('#job_date').focus();
            $('#hireperiod').focusout();
        },
        onClose: function() {
            this.blur();
        },
    });

    $("body").on("click","#job_search",function(){
        $('#job-request-table').DataTable().ajax.reload();
    });

    $("body").on("click","#job_search_reset",function(){
        $("#job_date").val('');
        $("#end_date").val('');
        $("#client_name").val('');
        $("#supervisor").val('');
        $("#job_title").val('');
        $("#status").val('');
        $('#job-request-table').DataTable().ajax.reload();
    });

    $("body").on("change","#start_time,#end_time",function(){
        var start_time = $("#start_time").val();
        var end_Time = $("#end_time").val();
        console.log(start_time);
        console.log(end_Time);
       
        str1 =  start_time.split(':');
        str2 =  end_Time.split(':');

        // totalSeconds1 = parseInt(str1[0] * 3600 + str1[1] * 60 + str1[0]);
        // totalSeconds2 = parseInt(str2[0] * 3600 + str2[1] * 60 + str2[0]);

        if(parseInt(str2[0]) != parseInt(str1[0])){
        if(parseInt(str2[0]) < parseInt(str1[0])){
            $("#start_time").val('');
            $("#end_time").val('');
            swal("Oops...", "Please select valid hours", "error");
        }
    }

        if(parseInt(str2[0]) == parseInt(str1[0])){
            if(parseInt(str2[1]) < parseInt(str1[1])){
                $("#start_time").val('');
                $("#end_time").val('');
                swal("Oops...", "Please select valid minutes", "error");
            }
        }
        
    });

    // Numeric only control handler
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

$("#no_of_employee").ForceNumericOnly();

});