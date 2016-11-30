$(document).ready(function()
{
  var searched = false;
  $('#btn-search').click(function(event){
    var filterby=$('#filterby').val();
    var textf = $("#datetimepicker").val();

    if(textf == '')
    {
      console.log('hello');
      $('#valid').slideDown().html('<span id="error">Please enter date</span>');
      return false;
    }

    else
    {
      searched = true;
      $('#valid').slideDown().html('<span id="success"></span>');
      $.ajax({
        type: 'POST',
        url: 'ajax_searchroom.php',
        data: {rtype:$('#hiddenType').val(), from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
        success: function(res)
        {
           $(".table-search").html(res);
        }
      });
    }
  });


      // return true;
      
      $('.radio-all').click(function(event)
      {
        $('#dis').slideDown().html('<span id="success"></span>');
        event.preventDefault();
        // var id = $('input#ticketID').val();
        jQuery.ajax({
          type: 'POST',
          url: 'ajax_searchroom.php',
          data: {rtype:'all', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
          success: function(res)
          {
            if (res)
            {
              if(searched)
              {
                $(".table-search").html(res);
                $("#hiddenType").val("all");
                $("input[class=radio-all]").prop("checked",true);
                $("input[class=radio-lecture]").prop("checked",false);
                $("input[class=radio-lab]").prop("checked",false);
                $("input[class=radio-outdoor]").prop("checked",false);
              }
              else
              {
                $("#hiddenType").val("all");
                $("input[class=radio-all]").prop("checked",true);
                $("input[class=radio-lecture]").prop("checked",false);
                $("input[class=radio-lab]").prop("checked",false);
                $("input[class=radio-outdoor]").prop("checked",false);
              }
              
            }
          }
        });
      });

        $('.radio-lecture').click(function(event)
        {
          $('#dis').slideDown().html('<span id="success"></span>');
          event.preventDefault();
          // var id = $('input#ticketID').val();
          jQuery.ajax({
            type: 'POST',
            url: 'ajax_searchroom.php',
            data: {rtype:'Lecture Room', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
            success: function(res) {
              if (res)
              {
                if(searched)
                {
                  $(".table-search").html(res);
                  $("#hiddenType").val("Lecture Room");
                  $("input[class=radio-all]").prop("checked",false);
                  $("input[class=radio-lecture]").prop("checked",true);
                  $("input[class=radio-lab]").prop("checked",false);
                  $("input[class=radio-outdoor]").prop("checked",false);
                }
                else
                {
                  $("#hiddenType").val("Lecture Room");
                  $("input[class=radio-all]").prop("checked",false);
                  $("input[class=radio-lecture]").prop("checked",true);
                  $("input[class=radio-lab]").prop("checked",false);
                  $("input[class=radio-outdoor]").prop("checked",false);
                }
                
              }
            }
          });
        });

         $('.radio-lab').click(function(event)
          {
            $('#dis').slideDown().html('<span id="success"></span>');
            event.preventDefault();
            // var id = $('input#ticketID').val();
            jQuery.ajax({
              type: 'POST',
              url: 'ajax_searchroom.php',
              data: {rtype:'Laboratory', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
              success: function(res) {
                if (res)
                {
                  if(searched)
                  {
                    $(".table-search").html(res);
                    $("#hiddenType").val("Laboratory");
                    $("input[class=radio-all]").prop("checked",false);
                    $("input[class=radio-lecture]").prop("checked",false);
                    $("input[class=radio-lab]").prop("checked",true);
                    $("input[class=radio-outdoor]").prop("checked",false);
                  }
                  else
                  {
                    $("#hiddenType").val("Laboratory");
                     $("input[class=radio-all]").prop("checked",false);
                    $("input[class=radio-lecture]").prop("checked",false);
                    $("input[class=radio-lab]").prop("checked",true);
                    $("input[class=radio-outdoor]").prop("checked",false);
                  }
                  
                }
              }
            });
          });
          $('.radio-outdoor').click(function(event)
          {
            $('#dis').slideDown().html('<span id="success"></span>');
            event.preventDefault();
            // var id = $('input#ticketID').val();
            jQuery.ajax({
              type: 'POST',
              url: 'ajax_searchroom.php',
              data: {rtype:'Outdoors', from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date:$('#datetimepicker').val()},
              success: function(res) {
                if (res)
                {
                  if(searched)
                  {
                     $(".table-search").html(res);
                    $("#hiddenType").val("Outdoors");
                    $("input[class=radio-all]").prop("checked",false);
                    $("input[class=radio-lecture]").prop("checked",false);
                    $("input[class=radio-lab]").prop("checked",false);
                    $("input[class=radio-outdoor]").prop("checked",true);
                  }
                  else
                  {
                    $("#hiddenType").val("Outdoors");
                    $("input[class=radio-all]").prop("checked",false);
                    $("input[class=radio-lecture]").prop("checked",false);
                    $("input[class=radio-lab]").prop("checked",false);
                    $("input[class=radio-outdoor]").prop("checked",true);

                  }
                 
                }
              }
            });
          });

});

