$(document).ready(function()
{
  $('#month').change(function(event)
  {
    event.preventDefault();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_viewReportTable.php',
      data: {type:$('#admin-type').val(), month:$('#month').val(), year: $('#year').val(), department:$('#department').val()},
      success: function(res) {
        if (res)
        {
          $(".report-div").html(res);
        }
      }
    });
  });

  $('#department').change(function(event)
  {
    event.preventDefault();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_viewReportTable.php',
      data: {type:$('#admin-type').val(), month:$('#month').val(), year: $('#year').val(), department:$('#department').val()},
      success: function(res) {
        if (res)
        {
          $(".report-div").html(res);
        }
      }
    });
  });
});
