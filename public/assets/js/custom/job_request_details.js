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
        var date = $("#job_date").val();
        var client = $("#client_name").val();
        var supervisour = $("#supervisor").val();
        $("#result_body").html('');
        $.ajax({
            type: 'GET',
            url: '/job_search_result',
            data: {
                "_token": "{{ csrf_token() }}",
                date:date,
                client:client,
                supervisour:supervisour
            },
            success: function (response) {
                if(response.success){
                    $.each(response.data, function(key, value) {
                        $("#result_body").append(value);
                    });
                }else{

                }
            },
            error: function (e) {
    
            }
        });

    });

    $("body").on("click",'.show_result',function(){
        if($(this).attr('data-status') == 'true'){
            $(this).attr('data-status','false')
            var id = $(this).attr('data-tableid');
            var job_id = $(this).attr('data-jobid');
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
                    swal("Your Request Under Process.");
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
                    swal("Your Request Under Process.");
                }
            },
            error: function (e) {
                swal("Oops...", "something went wrong", "error");
            }
        });
    });
});