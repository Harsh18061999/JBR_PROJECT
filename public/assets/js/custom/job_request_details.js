$(document).ready(function(){
    $("body").on("change","#client_name",function(){
        $("#supervisor").html('');
        $("#supervisor").append(`<option value="">Please select Supervisor</option>`);
        $.ajax({
            type: 'GET',
            url: '/get_supervisor',
            data: {
                "_token": "{{ csrf_token() }}",
                client_name:$(this).val()
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

    $("body").on("click","#Search_result",function(){
        var bulkmessage = [];
        var date = $("#job_date").val();
        var to_date = $("#end_date").val();
        var client = $("#client_name").val();
        var supervisour = $("#supervisor").val();
        $("#result_body").html('');
        $.ajax({
            type: 'GET',
            url: '/job_search_result',
            data: {
                "_token": "{{ csrf_token() }}",
                date:date,
                to_date:to_date,
                client:client,
                supervisour:supervisour
            },
            success: function (response) {
                if(response.success){
                    $.each(response.data, function(key, value) {
                        $("#result_body").append(value);
                    });
                }else{
                    $.each(response.data, function(key, value) {
                        $("#result_body").append(value);
                    });
                }
            },
            error: function (e) {
    
            }
        });

    });

    $("#Search_result_reset").on("click",function(){
        var bulkmessage = [];
        $("#job_date").val('');
        $("#end_date").val('');
        $("#client_name").val('');
        $("#supervisor").val('');
        $("#result_body").html('');
    });

    $("body").on("click",'.show_result',function(){
        if($(this).attr('data-status') == 'true'){
            $(this).attr('data-status','false')
            var id = $(this).attr('data-tableid');
            var job_id = $(this).attr('data-jobid');
            $.ajax({
                type: 'GET',
                url: '/total_employee_count',
                data: {
                    "_token": "{{ csrf_token() }}",
                    job_id:job_id
                },
                success: function (response) {
                    if(response){
                       $(".regular_count"+id).html(response.regular);
                       $(".aveilable_count"+id).html(response.available);
                       $(".oncall_count"+id).html(response.oncall);
                    }
                },
                error: function (e) {
        
                }
            });
            $("#regular"+id).DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                  url: "/regularDataTable",
                  type: "POST",
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                  data: function (search) {
                    search.postcode = $(".postcode").val();  
                    search.date = $(".date").val();
                    search.job_id = job_id;
                    search.table_id = id;
                  }
                },
                "drawCallback": function(settings) {
                  if(typeof(settings.json.recordsTotal) != "undefined" && settings.json.recordsTotal !== null){
                    if(settings.json.recordsTotal==0 || settings.json.recordsTotal=='0'){
                      $('#alert_msg').modal('show');
                    }
                  }
                },
                "language": {
                  "emptyTable": "No Results Found!!",
                  "lengthMenu": "Show _MENU_",
                },
                columns: [
                  { data: 'action', name: 'action'},
                  /*{ data: "abi_month_of_rates", name: 'abi_month_of_rates'},
                  { data: "abi_years_of_rates", name: 'abi_years_of_rates'},*/
                  { data: "first_name", name: 'first_name'},
                  { data: "last_name", name: "last_name"},
                  { data: "contact_number", name: "contact_number"},
                  { data: "message_status", name: "message_status"},
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[1, 'ASC']]
            });
            $("#available"+id).DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                responsive:false,
                ajax: {
                  url: "/availableDataTable",
                  type: "POST",
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                  data: function (search) {
                    search.postcode = $(".postcode").val();  
                    search.date = $(".date").val();
                    search.job_id = job_id;
                    search.table_id = id;
                  }
                },
                "drawCallback": function(settings) {
                  if(typeof(settings.json.recordsTotal) != "undefined" && settings.json.recordsTotal !== null){
                    if(settings.json.recordsTotal==0 || settings.json.recordsTotal=='0'){
                      $('#alert_msg').modal('show');
                    }
                  }
                },
                "language": {
                  "emptyTable": "No Results Found!!",
                  "lengthMenu": "Show _MENU_",
                  "processing": "<img style='left: 35%;margin-left: -32px;margin-top: -64px;position: absolute;top: 25%; z-index: 9999;' src='{{ URL::to('/admin-assets/images/icons/loader_10012020.gif') }}' />",
                },
                columns: [
                    { data: 'action', name: 'action'},
                    /*{ data: "abi_month_of_rates", name: 'abi_month_of_rates'},
                    { data: "abi_years_of_rates", name: 'abi_years_of_rates'},*/
                    { data: "first_name", name: 'first_name'},
                    { data: "last_name", name: "last_name"},
                    { data: "contact_number", name: "contact_number"},
                    { data: "message_status", name: "message_status"},
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[1, 'ASC']]
            });
            $("#oncall"+id).DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                responsive:false,
                ajax: {
                  url: "/onCallDataTable",
                  type: "POST",
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                  data: function (search) {
                    search.postcode = $(".postcode").val();  
                    search.date = $(".date").val();
                    search.job_id = job_id;
                    search.table_id = id;
                  }
                },
                "drawCallback": function(settings) {
                  if(typeof(settings.json.recordsTotal) != "undefined" && settings.json.recordsTotal !== null){
                    if(settings.json.recordsTotal==0 || settings.json.recordsTotal=='0'){
                      $('#alert_msg').modal('show');
                    }
                  }
                },
                "language": {
                  "emptyTable": "No Results Found!!",
                  "lengthMenu": "Show _MENU_",
                  "processing": "<img style='left: 35%;margin-left: -32px;margin-top: -64px;position: absolute;top: 25%; z-index: 9999;' src='{{ URL::to('/admin-assets/images/icons/loader_10012020.gif') }}' />",
                },
                columns: [
                    { data: 'action', name: 'action'},
                    /*{ data: "abi_month_of_rates", name: 'abi_month_of_rates'},
                    { data: "abi_years_of_rates", name: 'abi_years_of_rates'},*/
                    { data: "first_name", name: 'first_name'},
                    { data: "last_name", name: "last_name"},
                    { data: "contact_number", name: "contact_number"},
                    { data: "message_status", name: "message_status"},
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[1, 'ASC']]
            });
        }else{
            
        }
     
    });
    

    $("body").on("click",'.send_message',function(){
        var employee_id = $(this).attr('data-id');
        var job_id = $(this).attr('data-jobid');
        var table_id = $(this).attr('data-tableid');
        $.ajax({
            type: 'POST',
            url: '/send_message_job',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                employee_id:employee_id,
                job_id:job_id
            },
            success: function (response) {
                if(!response.success){
                    swal("Oops...", "something went wrong", "error");
                }else{
                    swal(response.message);
                    $('#regular'+table_id).DataTable().ajax.reload();
                    $('#available'+table_id).DataTable().ajax.reload();
                    $('#oncall'+table_id).DataTable().ajax.reload();
                    $.ajax({
                        type: 'GET',
                        url: '/total_employee_count',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            job_id:job_id
                        },
                        success: function (response) {
                            if(response){
                               $(".regular_count"+table_id).html(response.regular);
                               $(".aveilable_count"+table_id).html(response.available);
                               $(".oncall_count"+table_id).html(response.oncall);
                            }
                        },
                        error: function (e) {
                
                        }
                    });
                }
            },
            error: function (e) {
                swal("Oops...", "something went wrong", "error");
            }
        });
    })

    var bulkmessage = [];
    $("body").on("change",".regular_check",function(){
        var jobid = $(this).attr('data-jobid');
        var bulck_id = $(this).attr('data-bulck');
        var array = bulkmessage[bulck_id] == undefined ? [] : bulkmessage[bulck_id];
        if(this.checked){
            if(!array.includes($(this).val())){
                array.push($(this).val());
            }
        }else{
            array.splice(array.indexOf($(this).val()),1);
        }
        bulkmessage[bulck_id] = array;
        console.log(bulkmessage);
        if(array.length > 0){
            $("#bulkmessage"+bulck_id).css("display","block");
        }else{
            $("#bulkmessage"+bulck_id).css("display","none");
        }
    });

    $("body").on("click",".bulkmessage",function(){
        var job_id = $(this).attr('data-id');
        var click_id = $(this).attr('id');
        var table_id = click_id.replace("bulkmessage", "");
        $.ajax({
            type: 'POST',
            url: '/send_bulk_message_job',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                employee_id:bulkmessage[click_id.replace("bulkmessage", "")],
                job_id:job_id
            },
            success: function (response) {
                if(!response.success){
                    swal("Oops...", "something went wrong", "error");
                }else{
                    bulkmessage[click_id.replace("bulkmessage", "")] = '';
                    $('#regular'+table_id).DataTable().ajax.reload();
                    $('#available'+table_id).DataTable().ajax.reload();
                    $('#oncall'+table_id).DataTable().ajax.reload();
                    $.ajax({
                        type: 'GET',
                        url: '/total_employee_count',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            job_id:job_id
                        },
                        success: function (response) {
                            if(response){
                               $(".regular_count"+table_id).html(response.regular);
                               $(".aveilable_count"+table_id).html(response.available);
                               $(".oncall_count"+table_id).html(response.oncall);
                            }
                        },
                        error: function (e) {
                
                        }
                    });
                    swal(response.message);
                }
            },
            error: function (e) {
                swal("Oops...", "something went wrong", "error");
            }
        });
    });

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

    $("body").on("click",".show_on_going_result",function(){
        if($(this).attr('data-status') == 'true'){
            $(this).attr('data-status','false');
            var id = $(this).attr('data-tableid');
            var job_id = $(this).attr('data-jobid');
            $("#ongoing"+id).DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                  url: "/onGoingDataTable",
                  type: "POST",
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                  data: function (search) {
                    search.postcode = $(".postcode").val();  
                    search.date = $(".date").val();
                    search.job_id = job_id;
                    search.table_id = id;
                  }
                },
                "drawCallback": function(settings) {
                  if(typeof(settings.json.recordsTotal) != "undefined" && settings.json.recordsTotal !== null){
                    if(settings.json.recordsTotal==0 || settings.json.recordsTotal=='0'){
                      $('#alert_msg').modal('show');
                    }
                  }
                },
                "language": {
                  "emptyTable": "No Results Found!!",
                  "lengthMenu": "Show _MENU_",
                },
                columns: [
                  { data: "first_name", name: 'first_name'},
                  { data: "last_name", name: "last_name"},
                  { data: "contact_number", name: "contact_number"},
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[1, 'ASC']]
            });
        }
    });
});