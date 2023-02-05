$(document).ready(function(){
    $("#start_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: new Date(),
        autoclose: true,
        onSelect: function() {
            var startdate = $('#start_date').datepicker('getDate');
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
        minDate: new Date(),
        autoclose: true,
        onSelect: function() {
            var end_date = $('#end_date').datepicker('getDate');
            var startdate = $('#start_date').datepicker('getDate');
            if (startdate) {} else {
                var day = 60 * 60 * 24 * 1000;
                var startdate = new Date(end_date.getTime());
                $('#start_date').datepicker('setDate', startdate);
                $('#end_date').datepicker('option', 'minDate', new Date(startdate));
            }
            this.focus();
            $('#hireperiod').focus();
            $('#start_date').focus();
            $('#hireperiod').focusout();
        },
        onClose: function() {
            this.blur();
        },
    });

    $("body").on("click","#copyLink",function(){
        var copyText = $("#link_url").html();
        navigator.clipboard.writeText(copyText);
    });

    $("#campaign_from").validate({
        rules: {
            start_date:{ required:true },
            end_date:{ required:true },
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
});