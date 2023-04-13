// edit_time_sheet
$(document).ready(function(){
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

    $("body").on("click",'.save_time_sheet',function(){
        var id = $(this).attr('data-id');
        $("#start_time"+id).val();
        $("#break_time"+id).val();
        $("#end_time"+id).val();
    })
});;