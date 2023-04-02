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

    $("body").on("click","#weekly_scheduler",function(){
        var client_name = '';
        var supervisor = '';
        var week_id = '';
        var job_id = '';
        $.ajax({
            type: 'GET',
            url: '/weekly_scheduler',
            data: {
                "_token": "{{ csrf_token() }}",
                client_name:client_name,
                supervisor:supervisor,
                week_id:week_id,
                job_id:job_id,
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


    var table = $("#weekly").DataTable({
        searching: false,
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
          url: "/weekly_datatable",
          type: "POST",
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          data: function (search) {
            search.client_name = $("#client_name").val();  
            search.supervisor = $("#supervisor").val();
            search.job_title = $("#job_title").val();
            search.job_status =  $("#job_status").val();
            search.weekly = $("#job_search").attr("data-week");
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
        },
        columns: [
        //   { data: "Date", name: 'Date'},
          { data: "client_name", name: "client_name"},
          { data: "supervisor", name: "supervisor"},
          { data: "job_date", name: "job_date"},
          { data: "end_date", name: "end_date"},
        //   { data: "employee", name: "employee"},
          { data: "status", name: "status"},
          { data: "action", name: "action"},
        ],
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [[1, 'ASC']]
    });

    $("body").on("click","#job_search",function(){
        table.ajax.reload();
    });

    $("body").on("click","#current",function(){
        $("#job_search").attr("data-week",0);
        table.ajax.reload();
    });

    $("body").on("click","#previous",function(){
        $("#job_search").attr("data-week",1);
        table.ajax.reload();
    });

    $("body").on("click","#job_search_reset",function(){
        $("#client_name").val('');
        $("#supervisor").val('');
        $("#job_title").val('');
        $("#job_status").val('');
        table.ajax.reload();
    });

   
    // var table1 = '';
    // var destroy = false;
    $("body").on("click",".employee_list",function(){
        // var id = $(this).attr('data-tableid');
        var job_id = $(this).attr('data-id');
        // var table_name ="time_sheet_list";
    $('#employee_data').DataTable().clear().destroy();
      $("#job_request_id").val(job_id);
    //   if(destroy == true){
    //       table1.destroy();
    //     }
    $("#employee_data").DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            responsive: true,
            "bDestroy": true,
            dom: 'Bfrtip',
            retrieve: true,
            ajax: {
                url: "/onGoingDataTable",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (search) { 
                search.job_id =$("#job_request_id").val();
                }
            },
            createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class 
                console.log(data)
                $( row ).find('td:eq(4)')
                    .attr('data-id', data.id);
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
                { data: "Job_Status", name: "Job_Status"},
                {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
                },
            ],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            order: [[1, 'ASC']],
            drawCallback : function () {
                        
                function format(d) {
                    // `d` is the original data object for the row
                    console.log(d)
                    var string = '<table class="table table-bordered"><thead><tr><th scope="col">#</th><th scope="col">Job Date</th><th scope="col">Start Time</th><th scope="col">Brek Time</th><th scope="col">End Time</th><th>Total</th></tr></thead><tbody>';
                    if(d.length > 0){
                        d.forEach(function(fetch) {  
                            string += '<tr>';
                            string += '<td>'+fetch.id+'</td>';
                            string += '<td>'+fetch.job_date+'</td>';
                            string += '<td>'+fetch.start_time+'</td>';
                            string += '<td>'+fetch.break_time+'</td>';
                            string += '<td>'+fetch.end_time+'</td>';
                            string += '<td>'+fetch.total+'</td>';
                            string += '</tr>';
                        });  
                    }else{
                        string += '<tr>';
                        string += '<td colspan='+5+' class='+'text-center'+'>'+'No result Found'+'</td>';
                        string += '</tr>';
                    }
                    string += '</tbody>'+'</table>';
                    return (
                        string
                    );
                }
                function getTimesheet(id){
                    var data = '';
                        $.ajax({
                        type: 'get',
                        url: '/get_job_timesheet',
                        contentType: 'application/json',
                        dataType: 'json',
                        async: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        data:{
                            id:id
                        },
                        success: function(response) {
                            data = response; 
                        }
                    });
                    return data;
                }
                let tableData = $("#employee_data").DataTable();
                
                $('#employee_data tbody').on('click', 'td.dt-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tableData.row(tr);
                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        // Open this row
                        // var data = row.data();
                        var response = getTimesheet($(this).attr('data-id'));
                        
                        row.child(format(response)).show();
                        tr.addClass('shown');
                    }
                });
            },
        });
        // destroy = true;
    });

});