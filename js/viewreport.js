$(document).ready(function()
{
  $('#month').change(function(event)
  {
    event.preventDefault();
    //console.log($('#admin-type').val());
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_viewReportTable.php',
      data: {type:$('#admin-type').val(), month:$('#month').val(), year: $('#year').val()},
      success: function(res) {
        if (res)
        {
          $(".report-div").html(res);
        }
      }
    });
  });
});
