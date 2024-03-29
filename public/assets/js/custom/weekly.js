$(document).ready(function(){

    $("body").on("click","#job_search",function(){
       var custome_range = $("#custome_range").val();
       var job_date = $("#job_date").val();
       var end_date = $("#end_date").val();
       var client_name = $("#client_name").val();
       var supervisor = $("#supervisor").val();
       var url = window.location.href;    
       var url = url.substring(0, url.indexOf(","));

        if (custome_range == 2){
            url += `?custome_range=2&client_name=${client_name}&supervisor=${supervisor}`
        }else if(custome_range == 3){
            url += `?custome_range=3&client_name=${client_name}&supervisor=${supervisor}&job_date=${job_date}&end_date=${end_date}`;
        }else{
            url += `?custome_range=1&client_name=${client_name}&supervisor=${supervisor}`
        }
        window.location.href = url;
    });
    $("body").on("click","#job_search_reset",function(){
        $("#job_date").val('');
        $("#end_date").val('');
        $("#client_name").val('');
        $("#supervisor").val('');
        $("#job_title").val('');
        $("#status").val('');
        $("#custome_range").val('');
    });
    $("#job_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        // minDate: new Date(),
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

    $.validator.addMethod("valueNotEquals", function(value, element){
        return value != '' && value != null;
    }, "Please select field.");

    $("#job_category_from").validate({
        rules: {
            employee_available: { valueNotEquals: true, },
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


    $("#end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        // minDate: new Date(),
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


    $("body").on("change","#custome_range",function(){
        if($(this).val() == 3){
            $(".select_date").css("display","block");
        }else{
            $(".select_date").css("display","none"); 
        } 
    });

    
    $("body").on("click",".reallocate_job",function(){
        $("#reallocate_date").val($(this).attr("data-date"));
        $.ajax({
            type: 'GET',
            url: '/reallocate-job',
            data: {
                "_token": "{{ csrf_token() }}",
                "job_id" : $(this).attr("data-id"),
                "date" : $(this).attr("data-date"),
                "employee_id" : $(this).attr("data-employeeid"),
            },
            success: function (response) {
                if(response.success){
                    $("#employee_available").html("");
                    $("#reallcate_job_id").val(response.job_id);
                    $("#re_allocate_employee_id").val(response.employee_id);
                    $("#reallocate_date").val(response.job_date);
                    $("#employee_available").append($('<option>', { value: '', text: "Open this select menu" }));
                    $.each(response.employee, function(key, value) {
                        $("#employee_available").append($('<option>', { value: value.id, text: value.first_name + ' ' + value.last_name }));
                    });
                }
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    });

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


});