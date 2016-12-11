<table class="table table-hover" style="width:auto;z-index:840;">
    <thead class="tstyle" style="background-color:#3c8dbc;color:white;display:block;">
      <center>
        <th style="font-size: 12pt;padding-left:70pt;padding-right: 75pt;text-align:center;">Facility Name</th>
        <th style="font-size: 12pt;padding-left:80pt;padding-right: 70pt;text-align:center;">Type</th>
        <th style="font-size: 12pt;padding-left:80pt;padding-right: 70pt;text-align:center;">Action</th>
      </center>
</thead>
  <?php
  include('connects.php');
  include('qConn.php');

  $rtype = $_POST['rtype'];

  echo "<script>console.log('$rtype');</script>";

  date_default_timezone_set('Singapore');

  $current_date = date('m/d/Y');

  if (isset($rtype))
  {
    
    date_default_timezone_set("Asia/Singapore");
    $from = $_POST['from'];
    $to = $_POST['to'];

    //ARRAY FOR GETTING ALL ROOMS
    $arrayRoom = array();
    $arrayType = array();
    $arrayDesc = array();

    //$rtype = $_POST['roomType'];
    $date = $_POST['date'];
    $timestamp = strtotime($date);
    $day = date('l', $timestamp);

    //ARRAY FOR VACANT ROOMS
    $arrayVacantRoom = array();
    $arrayVacantType = array();
    $arrayVacantDesc = array();

    $arrayFinalRoom = array();
    $arrayFinalType = array();
    $arrayFinalDesc = array();

    $arrayStatus = array();

    $tempRooms = array();
    $tempFrom = array();
    $tempTo = array();

    if ($from >= $to)
    {
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
    }
    else
    {
      //GET ALL ROOMS OF SAME TYPE
      $getRooms = GetRooms($con,$rtype);

      if(mysqli_num_rows($getRooms) > 0)
      {
        while($row = mysqli_fetch_array($getRooms))
        {
         $arrayRoom[] = $row['rRoom'];
       }
     }

     for($roomCtr = 0 ; $roomCtr < count($arrayRoom) ; $roomCtr++)
     {
      $arrayTemp = array();

      for($ctrFrom1 = $from ; $ctrFrom1 < $to ; $ctrFrom1++)
      {
         $getStatusQuery = GetRStat($con,$arrayRoom[$roomCtr],$ctrFrom1,$day);

        if(mysqli_num_rows($getStatusQuery) > 0)
        {
          while($row = mysqli_fetch_array($getStatusQuery))
          {
            $arrayTemp[] = $row['rStatus'];
          }
        }
      }

      if (in_array("Occupied", $arrayTemp))
      {

      }
      else
      {
        $arrayVacantRoom[] = $arrayRoom[$roomCtr];
      }
    }

    $getRequestFromSameDate = GetRequestSameDate($con,$date);

    if(mysqli_num_rows($getRequestFromSameDate) > 0)
    {
      while($row = mysqli_fetch_array($getRequestFromSameDate))
      {
        $tempRooms[] = $row['room'];
        $tempFrom[] = ConvertToTid($con,$row['timeFrom']);
        $tempTo[] = ConvertToTid($con,$row['timeTo']);
      }
    }
    
    for($ctr2=0; $ctr2<count($tempRooms); $ctr2++)
    {
      if(($tempFrom[$ctr2] > $from && $tempFrom[$ctr2] < $to) || ($tempTo[$ctr2] > $from && $tempTo[$ctr2] < $to) || ($tempFrom[$ctr2] <= $from && $tempTo[$ctr2] >= $to))
      {
        $arrayVacantRoom = array_diff($arrayVacantRoom, array($tempRooms[$ctr2]));
      }
    }

    $arrayFinalRoom = array_values($arrayVacantRoom);

    for($ctr=0; $ctr<count($arrayFinalRoom); $ctr++)
    {
      $getType = GetRoomTable($con,$arrayFinalRoom[$ctr]);

      if(mysqli_num_rows($getType) > 0)
      {
        while($row = mysqli_fetch_array($getType))
        {
          $arrayFinalType[] = $row['rType'];
        }
      }
    }

      $fromTime = GetFromTime($con,$from);
      $toTime = GetToTime($con,$to);

      //echo count($arrayVacantRoom);

      echo "<tbody style='height:250pt;display:block;overflow-y:auto'>";
      for($ctr = 0 ; $ctr < count($arrayFinalRoom) ; $ctr++)
      {
        echo "<tr>";
        echo "<td style='width:220pt;text-align:center;'>$arrayFinalRoom[$ctr]</td>";
        echo "<td style='width:200pt;text-align:center;'>$arrayFinalType[$ctr]</td>";

        echo "<td style='padding-left:70pt;padding-right:70pt;text-align:center;'><a href='#' class='btn-block btn-success view-data' name='$arrayFinalType[$ctr]' id='$arrayFinalRoom[$ctr]'><span class='glyphicon glyphicon-plus view-data' title='Request Room'></span></a></td>";
        echo "</tr>";
      }
          echo "</tbody>";
    }
  }

  ?>
</table>

<!--MODALS-->
<form action='requestRoomModal.php' method='post'>
<div id="dataModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background-color:#428bca;color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        <h4 class="modal-title">Request Details</h4>
      </div>
     
      <div class="modal-body" id="request-details">
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>
</div>
</form>
<!--END MODAL-->

<script>
  $(document).ready(function(){
    $('.view-data').click(function(){
      var rroom = $(this).attr("id");
      var rtype = $(this).attr("name");

      $.ajax({
        url:"viewmodal.php",
        method:"post",
        data:{rroom, rtype, from:$('#cmbFrom').val(), to: $('#cmbTo').val(), date: $('#datetimepicker').val()},
        success:function(data){
          $('#request-details').html(data);
          $('#dataModal').modal("show"); 
        }
      });
    });
  });
</script>
