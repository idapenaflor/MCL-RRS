$(document).ready(function()
{
  $('.view-details').click(function(){
    var requestID = $(this).attr("id");
    $.ajax({
      url:"viewDetailsModal.php",
      method:"post",
      data:{requestID},
      success:function(data){
        $('#request-details').html(data);
        $('#detailsModal').modal("show"); 
      }
    });
  });

  $('.cancel-request').click(function(){
    var requestID = $(this).attr("id");
    $.ajax({
      url:"viewCancelModal.php",
      method:"post",
      data:{requestID},
      success:function(data){
        $('#cancel-request').html(data);
        $('#cancelModal').modal("show"); 
      }
    });
  });
});