$(document).ready(function() {


$('#company_name').click(function(event) {
    $("#addData").modal('show');

});


$('.company-name').click(function(event) {
    var company_id = $(this).data('company-id');
    var lead_id = $(this).data('lead-id');
    var company_name = $(this).data('company-name');


$('#company_id').val(company_id);
$('#lead_id').val(lead_id);
$('#company_name').val(company_name);

$('#company_selected').val('true');


});





$('.timepicker').timepicker({
});


function am_pm_to_hours(time) {

        var hours = parseInt(time.substring(0,2));
        var minutes = parseInt(time.substring(3,5));       
        var AMPM = time.match(/\s(.*)$/)[1];
        if (AMPM == "PM" && hours < 12) hours = hours + 12;
        if (AMPM == "AM" && hours == 12) hours = hours - 12;

        return total_minutes = hours*60 + minutes;
    }


$('.timepicker').timepicker({
    defaultTime:'current',
    showMeridian:false
});

$('#start_time').change(function(event) {
    
    var start_time = $("#start_time").val();
    var end_time = $("#end_time").val();
    var meeting_time;

    if (start_time != 0 && end_time != 0){
        var start_time_minutes = am_pm_to_hours(start_time);
        var finish_time_minutes = am_pm_to_hours(end_time);
        if (finish_time_minutes > start_time_minutes) meeting_time = finish_time_minutes - start_time_minutes;
    }

    $('#duration').val(meeting_time);

});


$('#end_time').change(function(event) {
    
    var start_time = $("#start_time").val();
    var end_time = $("#end_time").val();
    var meeting_time;

    if (start_time != 0 && end_time != 0){
        var start_time_minutes = am_pm_to_hours(start_time);
        var finish_time_minutes = am_pm_to_hours(end_time);
        if (finish_time_minutes > start_time_minutes) meeting_time = finish_time_minutes - start_time_minutes;
    }

    $('#duration').val(meeting_time);

});


        $('.datepicker').each(function(index, el) {
            $(el).datepicker({
                 format: 'yyyy-mm-dd',
        });

        $('.datepicker').bind('input',function(e) {
           
            $(this).css('font-size', '0');
                // $(this).val('').datepicker('update');
            
            setTimeout(function() {

                $(this).val('').datepicker('update');
                $(this).css('font-size', '14px');

            }.bind(this), 300);

        });


                $('#project_finish_time').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function (ev) {


                  var start_time = $("#project_start_time").val();
                  var finish_time = $("#project_finish_time").val();


                  var start_time_day_value = parseInt(start_time.substring(8, 10));
                  var finish_time_day_value = parseInt(finish_time.substring(8, 10));


                  if(finish_time_day_value > start_time_day_value){
                    var duration = finish_time_day_value - start_time_day_value;

                    $('#duration').val(duration);

                }
                
            });


                $('#project_start_time').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function (ev) {


                  var start_time = $("#project_start_time").val();
                  var finish_time = $("#project_finish_time").val();


                  var start_time_day_value = parseInt(start_time.substring(8, 10));
                  var finish_time_day_value = parseInt(finish_time.substring(8, 10));


                  if(finish_time_day_value > start_time_day_value){
                    var duration = finish_time_day_value - start_time_day_value;

                    $('#duration').val(duration);

                }
                
            });

        });


});




