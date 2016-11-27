<table class="table table-striped" style="width: auto;text-align:center;z-index:840;">
    <thead class="tstyle" style="background-color:#3c8dbc;color:white;display:block;">
      <center>
        <th style="font-size: 12pt;padding-left:75pt;padding-right: 75pt;text-align:center;">Room Name</th>
        <th style="font-size: 12pt;padding-left:70pt;padding-right: 70pt;text-align:center;">Type</th>
        <th style="font-size: 12pt;padding-left:70pt;padding-right: 70pt;text-align:center;">Action</th>
      </center>
</thead>
  <?php
  include('connects.php');

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
      echo "<script language='javascript'>alert('Please select valid time range');</script>";
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
    }
    else
    {
      //GET ALL ROOMS OF SAME TYPE
      if($rtype == "all")
      {
        $qAGet = "select * from roomtable";
       $getRooms = mysqli_query($con,$qAGet); 
      }
      else
      {
        $qGetRooms = "select * from roomtable where rtype = '$rtype'";
       $getRooms = mysqli_query($con,$qGetRooms); 
      }

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
         $qGetStat = "select scheduletable.rStatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'";
         $getStatusQuery = mysqli_query($con,$qGetStat);

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

    $qGetRequest = "select * from requests where dateOfUse='$date' and status='Approved' or dateOfUse='$date' and status='Pending'";
    $getRequestFromSameDate = mysqli_query($con,$qGetRequest);

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
      $qGetType = "select rType from roomtable where rRoom='$arrayFinalRoom[$ctr]'";
      $getType = mysqli_query($con,$qGetType);

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

      echo "<tbody style='height:300pt;display:block;overflow-y:auto'>";
      for($ctr = 0 ; $ctr < count($arrayFinalRoom) ; $ctr++)
      {
        echo "<tr>";
        echo "<td style='padding-left:65pt;padding-right: 75pt;text-align:center;'>$arrayFinalRoom[$ctr]</td>";
        echo "<td style='padding-left:50pt;padding-right:50pt;'>$arrayFinalType[$ctr]</td>";

        echo "<td style='padding-left:70pt;padding-right:70pt;text-align:center;'><a href='#' class='btn-block btn-success view-data' name='$arrayFinalType[$ctr]' id='$arrayFinalRoom[$ctr]'><span class='glyphicon glyphicon-plus view-data' title='Request Room'></span></a></td>";
        echo "</tr>";
      }
          echo "</tbody>";
    }
  }

  //FUNCTIONS HERE
  function GetFromTime($con,$from) //get start time
  {

    //$qGetFrom = "select tTime from timetable where tid = '$from'";
    $getFromTime = mysqli_query($con,"select tTime from timetable where tid = '$from'");

    if(mysqli_num_rows($getFromTime)>0)
    {
      while($row = mysqli_fetch_array($getFromTime))
      {
        $fromTime = $row['tTime'];
      } 
    }

    return $fromTime;
  }

  function GetToTime($con,$to) //get end time
  {
    $toTime = "";
    $qGetTo = "select tTime from timetable where tid = '$to'";
    $getToTime = mysqli_query($con,$qGetTo);

    if(mysqli_num_rows($getToTime)>0)
    {
      while($row = mysqli_fetch_array($getToTime))
      {
        $toTime = $row['tTime'];
      }
    }

    return $toTime;
  }

  function ConvertToTid($con,$time)
  {
    $qGetID = "select tID from timetable where tTime = '$time'";
    $getTid = mysqli_query($con,$qGetID);

    if(mysqli_num_rows($getTid)>0)
    {
      while($row = mysqli_fetch_array($getTid))
      {
        $time = $row['tID'];
      }
    }

    return $time;
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
