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

    $("body").on("click","#job_search",function(){
        $('#client-job-request-table').DataTable().ajax.reload();
    });

    $("body").on("click","#job_search_reset",function(){
        $("#job_date").val('');
        $("#end_date").val('');
        $("#client_name").val('');
        $("#supervisor").val('');
        $("#job_title").val('');
        $("#status").val('');
        $("#custome_range").val('');
        $('#client-job-request-table').DataTable().ajax.reload();
    });

    $("body").on("change","#custome_range",function(){
        if($(this).val() == 3){
            $(".select_date").css("display","block");
        }else{
            $(".select_date").css("display","none"); 
        }
            
    });

});