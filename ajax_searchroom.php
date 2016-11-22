<table class="table table-striped" style="width: auto;text-align:center;z-index:840;">
    <thead class="tstyle" style="background-color:#3c8dbc;color:white;display:block;border-radius:5px;">
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

    $arrayStatus = array();

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
       $getRooms = mysql_query("select * from roomtable"); 
      }
      else
      {
       $getRooms = mysql_query("select * from roomtable where rtype = '$rtype'"); 
      }

      if(mysql_num_rows($getRooms) > 0)
      {
        while($row = mysql_fetch_array($getRooms))
        {
         $arrayRoom[] = $row['rRoom'];
         $arrayType[] = $row['rType'];
         $arrayDesc[] = $row['rdesc'];
       }
     }

     for($roomCtr = 0 ; $roomCtr < count($arrayRoom) ; $roomCtr++)
     {
      $arrayTemp = array();

      for($ctrFrom1 = $from ; $ctrFrom1 < $to ; $ctrFrom1++)
      {
         // $getStatusQuery = mysql_query("select scheduletable.rStatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'");
        $getStatusQuery = mysql_query("select scheduletable.rStatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'");

        if(mysql_num_rows($getStatusQuery) > 0)
        {
          while($row = mysql_fetch_array($getStatusQuery))
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
        $arrayVacantType[] = $arrayType[$roomCtr];
        $arrayVacantDesc[] = $arrayDesc[$roomCtr];
      }
    }

    //echo "<form action='requestRoom.php' method='post'>";

      $fromTime = GetFromTime($from);
      $toTime = GetToTime($to);

      echo "<tbody style='height:300pt;display:block;overflow-y:auto'>";
      for($ctr = 0 ; $ctr < count($arrayVacantRoom) ; $ctr++)
      {
        echo "<tr>";
        echo "<td style='padding-left:65pt;padding-right: 75pt;text-align:center;'>$arrayVacantRoom[$ctr]</td>";
        echo "<td style='padding-left:50pt;padding-right:50pt;'>$arrayVacantType[$ctr]</td>";

        //echo "<td style='padding-left:90pt;padding-right:95pt;'><a href='requestRoom.php?room=$arrayVacantRoom[$ctr]&rtype=$arrayVacantType[$ctr]&from=$fromTime&to=$toTime&fromindex=$from&dateofuse=$date&currentdate=$current_date' class='btn-block btn-success'><span class='glyphicon glyphicon-plus view-data' title='Request Room'></span></a></td>";
        echo "<td style='padding-left:70pt;padding-right:70pt;text-align:center;'><a href='#' class='btn-block btn-success view-data' name='$arrayVacantType[$ctr]' id='$arrayVacantRoom[$ctr]'><span class='glyphicon glyphicon-plus view-data' title='Request Room'></span></a></td>";
        echo "</tr>";
      }
          echo "</tbody>";
    }
  }

  //FUNCTIONS HERE
  function GetFromTime($from) //get start time
  {
    $getFromTime = mysql_query("select tTime from timetable where tid = $from");

    if(mysql_num_rows($getFromTime)>0)
    {
      while($row = mysql_fetch_array($getFromTime))
      {
        $fromTime = $row['tTime'];
      } 
    }

    return $fromTime;
  }

  function GetToTime($to) //get end time
  {
    $toTime = "";
    $getToTime = mysql_query("select tTime from timetable where tid = $to");
    if(mysql_num_rows($getToTime)>0)
    {
      while($row = mysql_fetch_array($getToTime))
      {
        $toTime = $row['tTime'];
      }
    }

    return $toTime;
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
