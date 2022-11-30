$(document).ready(function(){
    $("#acceptJob").click( function() {
        swal({
            title: "Are you sure?",
            text: "You want to confirm this job.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#acceptJobForm").submit();
            }
        })
    });

    $("#cancelJob").click( function() {
        swal({
            title: "Are you sure?",
            text: "You want to cancell this job.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#cancelJobForm").submit();
            }
        })
    });
   
});