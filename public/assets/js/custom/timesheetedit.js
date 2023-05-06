// edit_time_sheet
$(document).ready(function(){
    var url =  window.location.href;
    $("body").on("click",".edit_time_sheet",function(){
        var id = $(this).attr('data-id');
        $("#start_time"+id).prop('disabled',false);
        $("#break_time"+id).prop('disabled',false);
        $("#end_time"+id).prop('disabled',false);
        $(this).css('display','none');
        $("#cancle"+id).css("display","block")
    });

    $("body").on("click",".cancle_time_sheet",function(){
        var id = $(this).attr('data-id');
        $("#start_time"+id).prop('disabled',true);
        $("#break_time"+id).prop('disabled',true);
        $("#end_time"+id).prop('disabled',true);
        $(this).css('display','none');
        $("#edit"+id).css("display","block")
    });

    $("body").on("click",".not_apprpved_time_sheet",function(){
        var job_id = $(this).attr('data-jobid');
        var employee_id = $(this).attr('data-employeeid');
        var allocate = $(this).attr("data-reallocate");
        swal({
            title: "Are you sure?",
            text: "You want cancle the time sheet",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: '/not_approve_time_sheet',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id : job_id ,
                        employee_id :  employee_id,
                        allocate : allocate
                    },
                    success: function (response) {
                        if(response.success){
                          
                          $("#not_approve"+job_id).css('display',"none");
                          $("#approve"+job_id).css('display',"inline-block");
                          swal("Time sheet has been cancled");
                          window.location.href = url;
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                    }
                });
            }
        });
    
    })

    $("body").on("click",".license_view,#edit_license_view",function(){
        $('#modalScrollable').modal('toggle');
        var str =  $(this).attr('data-href');
        var test = (/\.(gif|jpg|jpeg|tiff|png)$/i).test(str)
        if(test){
            $("#my_img").attr("src",$(this).attr('data-href'));
            $("#my_img").css("display","block");
            $("#myFrame").css("display","none");
        }else{
            $("#myFrame").attr("src",$(this).attr('data-href'));
            $("#my_img").css("display","none");
            $("#myFrame").css("display","block");
        }
        $("#license_download").attr('href',$(this).attr('data-href'));
        $("#license_download").attr('download',$(this).attr('data-pdfname'));
    });
    
    $("body").on("click",".apprpved_time_sheet",function(){
        var job_id = $(this).attr('data-jobid');
        var allocate = $(this).attr("data-reallocate");
        var employee_id = $(this).attr('data-employeeid');
        swal({
            title: "Are you sure?",
            text: "Yoy want approved the time sheet",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: '/approve_time_sheet',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id : job_id ,
                        employee_id :  employee_id,
                        allocate : allocate
                    },
                    success: function (response) {
                        if(response.success){
                          $("#not_approve"+job_id).css('display',"inline-block");
                          $("#approve"+job_id).css('display',"none");
                          swal("Time sheet has been approved");
                          window.location.href = url;
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                    }
                });
            }
        });

        
    });

    $("body").on("click",'.save_time_sheet',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: '/save_time_sheet',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_id : id ,
                start_time :  $("#start_time"+id).val(),
                break_time :  $("#break_time"+id).val(),
                end_time : $("#end_time"+id).val()
            },
            success: function (response) {
                if(response.success){
                    $("#start_time"+id).prop('disabled',true);
                    $("#break_time"+id).prop('disabled',true);
                    $("#end_time"+id).prop('disabled',true);
                    $("#cancle"+id).css("display","none")
                    $("#edit"+id).css("display","block")
                    $("#total_time"+id).html(response.total);
                    swal("Details has been update");
                }
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    })
});;