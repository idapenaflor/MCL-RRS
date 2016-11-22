$(document).ready(function()
{
  $('.radio-all').click(function(event)
  {
    event.preventDefault();
    // var id = $('input#ticketID').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_searchroom.php',
      data: {rtype:'all', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
      success: function(res) {
        if (res)
        {
          $(".table-search").html(res);
          $("#hiddenType").val("all");
          $("input[name=radio-all]").prop("checked",true);
          $("input[name=radio-lecture]").prop("checked",false);
          $("input[name=radio-lab]").prop("checked",false);
          $("input[name=radio-outdoor]").prop("checked",false);
        }
      }
    });
  });

  $('.radio-lecture').click(function(event)
  {
    event.preventDefault();
    // var id = $('input#ticketID').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_searchroom.php',
      data: {rtype:'Lecture Room', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
      success: function(res) {
        if (res)
        {
          $(".table-search").html(res);
          $("#hiddenType").val("Lecture Room");
          $("input[name=radio-all]").prop("checked",false);
          $("input[name=radio-lecture]").prop("checked",true);
          $("input[name=radio-lab]").prop("checked",false);
          $("input[name=radio-outdoor]").prop("checked",false);
        }
      }
    });
  });

  $('.radio-lab').click(function(event)
  {
    event.preventDefault();
    // var id = $('input#ticketID').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_searchroom.php',
      data: {rtype:'Laboratory', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
      success: function(res) {
        if (res)
        {
          $(".table-search").html(res);
          $("#hiddenType").val("Laboratory");
          $("input[name=radio-all]").prop("checked",false);
          $("input[name=radio-lecture]").prop("checked",false);
          $("input[name=radio-lab]").prop("checked",true);
          $("input[name=radio-outdoor]").prop("checked",false);
        }
      }
    });
  });

  $('.radio-outdoor').click(function(event)
  {
    event.preventDefault();
    // var id = $('input#ticketID').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_searchroom.php',
      data: {rtype:'Outdoors', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
      success: function(res) {
        if (res)
        {
          $(".table-search").html(res);
          $("#hiddenType").val("Outdoors");
          $("input[name=radio-all]").prop("checked",false);
          $("input[name=radio-lecture]").prop("checked",false);
          $("input[name=radio-lab]").prop("checked",false);
          $("input[name=radio-outdoor]").prop("checked",true);
        }
      }
    });
  });

  $('.btn-search').click(function(event)
  {
    event.preventDefault();
    // var id = $('input#ticketID').val();
    jQuery.ajax({
      type: 'POST',
      url: 'ajax_searchroom.php',
      data: {rtype:$("#hiddenType").val(), from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
      success: function(res) {
        if (res)
        {
          $(".table-search").html(res);
        }
      }
    });
  });


});
