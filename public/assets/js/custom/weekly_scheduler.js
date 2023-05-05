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



});