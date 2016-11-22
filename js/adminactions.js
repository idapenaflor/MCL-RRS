function clickbtn(t)
{
  if(t.id == 'approve')
  {
    if (confirm('Are you sure you want to approve request?'))
    {
      
    }
    else
    {
      return false;
    }
  }
  else if(t.id == 'reject')
  {
    if (confirm('Are you sure you want to reject request?'))
    {
      
    }
    else
    {
      return false;
    }
  }
}
    
$(document).ready(function(){
  $('.view-equipment').click(function(){
    var requestID = $(this).attr("id");
    $.ajax({
      url:"viewEquipmentModal.php",
      method:"post",
      data:{requestID},
      success:function(data){
        $('#equipment-details').html(data);
        $('#equipmentModal').modal("show"); 
      }
    });
  });

  $('.reject-request').click(function(){
    var requestID = $(this).attr("id");
    var action = "Rejected";

    $.ajax({
      url:"viewRejectModal.php",
      method:"post",
      data:{requestID, action},
      success:function(data){
        $('#reject-request').html(data);
        $('#rejectModal').modal("show"); 
      }
    });
  });

  $('.approve-request').click(function(){
    var requestID = $(this).attr("id");
    var action = "Approved";

    $.ajax({
      url:"viewRejectModal.php",
      method:"post",
      data:{requestID, action},
      success:function(data){
        $('#approve-request').html(data);
        $('#approveModal').modal("show"); 
      }
    });
  });
});
    