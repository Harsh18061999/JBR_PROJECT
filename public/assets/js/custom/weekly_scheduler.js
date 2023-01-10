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
        searching: true,
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
          "lengthMenu": "Show _MENU_",
        },
        columns: [
          { data: "Date", name: 'Date'},
          { data: "client_name", name: "client_name"},
          { data: "supervisor", name: "supervisor"},
          { data: "employee", name: "employee"},
          { data: "status", name: "status"},
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

});