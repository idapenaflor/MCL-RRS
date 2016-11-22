<style type='text/css'>
#rt
{
	font-size: 30px;
	color: #bdc3c7;
}
</style>
<?php

include('connects.php');
$placeHolder = "Select your preferred schedule and click search.";
echo "<span id='rt' name='placeHolder'><br><br>$placeHolder</span>";
if (isset($_POST['submit3']))
	 {
		 echo "<script language='Javascript'>document.getElementById('rt').innerHTML = '';</script>";
			 //echo $_POST['cmbFrom'] . "<br>";
	 date_default_timezone_set("Asia/Singapore");
	 $from = $_POST['cmbFrom'];
	 $arrayRoom = array();
	 $rtype = $_POST['roomType'];
	 $date = $_POST['datetimepicker'];
	 $timestamp = strtotime($date);
	 $day = date('l', $timestamp);

	 $arrayVacantRoom = array();
	 echo "<form action='RequestRoom.php' method='post'>";
	 echo "<input type='hidden' name='hiddenFName' value=$fname>";
	 echo "<input type='hidden' name='hiddenLName' value=$lname>";
	 echo "<input type='hidden' name='hiddenDept' value=$dept>";
	 if($from == 9)
	 {

     //echo "<div id='AvailableRooms' style='width: 99%; overflow:auto; height:40vh; background-color: blue;'>";
     echo "<center><table class='TFtableCol'>
       <tr>";

        $getFromTime = mysql_query("select tTime from timetable where tid = $from");
        if(mysql_num_rows($getFromTime)>0)
        {
          while($row = mysql_fetch_array($getFromTime))
          {
            $fromTime = $row['tTime'];
          }
        }

        /*$getToTime = mysql_query("select tTime from timetable where tid = $to");
        if(mysql_num_rows($getToTime)>0)
        {
          while($row = mysql_fetch_array($getToTime))
          {
            $toTime = $row['tTime'];
          }
        }*/

       echo"<th>Available Rooms [$fromTime - 8:30pm, $day]</th>";

       echo "</tr>";
       //get all rooms
       $getRooms = mysql_query("select rroom from roomtable where rType=$rType");
       if(mysql_num_rows($getRooms) > 0)
       {
         while($row = mysql_fetch_array($getRooms))
         {
           $arrayRoom[] = $row['rroom'];
           echo "<br>";
           echo $row['rroom'];
         }
       }

       for($roomCtr = 0 ; $roomCtr < count($arrayRoom) ; $roomCtr++)
       {
         $arrayTemp = array();
       //  echo "<br><br>";
       //  echo $arrayRoom[$roomCtr];

           $getStatusQuery = mysql_query("select scheduletable.rstatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$from' and scheduletable.rday = '$day'");

           if(mysql_num_rows($getStatusQuery) > 0)
           {
             while($row = mysql_fetch_array($getStatusQuery))
             {
               $arrayTemp[] = $row['rstatus'];
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

       $ctr = 0;
       for ($showRoomCtr = 0 ; $showRoomCtr < count($arrayVacantRoom) ; $showRoomCtr++)
       {
         echo "<tr>";
         echo "<td>  <input type='submit' name='room[".$ctr."]' class='tableButton' value=$arrayVacantRoom[$showRoomCtr]> </td>";
         echo "</tr>";

         echo "<input type='hidden' name='hiddenname[".$ctr."]' value=$arrayVacantRoom[$showRoomCtr]>";
         echo "<input type='hidden' name='hiddenFrom[".$ctr."]' value=$fromTime>";
         echo "<input type='hidden' name='hiddenTo[".$ctr."]' value='8:30pm'>";
				 echo "<input type='hidden' name='hiddenFromIndex[".$ctr."]' value=$from>";

         $ctr++;
       }
       echo "</table></center>";
       echo "</form>";
	 }

	 else
	 {
		 //echo $_POST['cmbTo'];
		 $to = $_POST['cmbTo'];

		 //BINAGO NI YSSA HUAHUAHUAHUAHUAHUAHUAHUAHUA HAHAHAHAHAHAHAHAHAHAHAHAHAHA XD
		 if ($from >= $to)
		 {
			 echo "<script language='javascript'>alert('Please select valid time range');</script>";
			  echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=Main.php\">";
		 }
		 else
		 {
       elsePath($from, $to, $day, $arrayRoom, $arrayVacantRoom);
	   }

	 }
	 mysql_close($con);
   }

   function elsePath($from, $to, $day, $array, $arrayVacantRoom)
   {
     //echo "<div id='AvailableRooms' style='width: 99%; overflow:auto; height:40vh; background-color: blue;'>";
		 if ($to == 10)
		 {
			 echo "<center><table class='TFtableCol'>
	       <tr>";

	        $getFromTime = mysql_query("select tTime from timetable where tid = $from");
	        if(mysql_num_rows($getFromTime)>0)
	        {
	          while($row = mysql_fetch_array($getFromTime))
	          {
	            $fromTime = $row['tTime'];
	          }
	        }

	        $getToTime = mysql_query("select tTime from timetable where tid = '9'");
	        if(mysql_num_rows($getToTime)>0)
	        {
	          while($row = mysql_fetch_array($getToTime))
	          {
	            $toTime = $row['tTime'];
	          }
	        }

	       echo"<th>Available Rooms [$fromTime - 8:30pm, $day]</th>";

	       echo "</tr>";
	       //get all rooms
	       $getRooms = mysql_query("select rroom from roomtable");
	       if(mysql_num_rows($getRooms) > 0)
	       {
	         while($row = mysql_fetch_array($getRooms))
	         {
	           $arrayRoom[] = $row['rroom'];
	           //echo "<br>";
	         //  echo $row['rroom'];
	         }
	       }

	       for($roomCtr = 0 ; $roomCtr < count($arrayRoom) ; $roomCtr++)
	       {
	         $arrayTemp = array();
	       //  echo "<br><br>";
	       //  echo $arrayRoom[$roomCtr];
	         for($ctrFrom1 = $from ; $ctrFrom1 < 9 ; $ctrFrom1++)
	         {
	           $getStatusQuery = mysql_query("select scheduletable.rstatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'");

	           if(mysql_num_rows($getStatusQuery) > 0)
	           {
	             while($row = mysql_fetch_array($getStatusQuery))
	             {
	               $arrayTemp[] = $row['rstatus'];
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

	       $ctr = 0;
	       for ($showRoomCtr = 0 ; $showRoomCtr < count($arrayVacantRoom) ; $showRoomCtr++)
	       {
	         echo "<tr>";
	         echo "<td>  <input type='submit' name='room[".$ctr."]' class='tableButton' value=$arrayVacantRoom[$showRoomCtr]> </td>";
	         echo "</tr>";

	          echo "<input type='hidden' name='hiddenname[".$ctr."]' value=$arrayVacantRoom[$showRoomCtr]>";
	          echo "<input type='hidden' name='hiddenFrom[".$ctr."]' value=$fromTime>";
	          echo "<input type='hidden' name='hiddenTo[".$ctr."]' value='8:30pm'>";
						echo "<input type='hidden' name='hiddenFromIndex[".$ctr."]' value=$from>";
	          echo "<input type='hidden' name='hiddenToIndex[".$ctr."]' value=$to>";
	         $ctr++;
	       }
		 }
		 else {
			 echo "<center><table class='TFtableCol'>
         <tr>";

          $getFromTime = mysql_query("select tTime from timetable where tid = $from");
          if(mysql_num_rows($getFromTime)>0)
          {
            while($row = mysql_fetch_array($getFromTime))
            {
              $fromTime = $row['tTime'];
            }
          }

          $getToTime = mysql_query("select tTime from timetable where tid = $to");
          if(mysql_num_rows($getToTime)>0)
          {
            while($row = mysql_fetch_array($getToTime))
            {
              $toTime = $row['tTime'];
            }
          }

         echo"<th>Available Rooms [$fromTime - $toTime, $day]</th>";

         echo "</tr>";
         //get all rooms
         $getRooms = mysql_query("select rroom from roomtable");
         if(mysql_num_rows($getRooms) > 0)
         {
           while($row = mysql_fetch_array($getRooms))
           {
             $arrayRoom[] = $row['rroom'];
             //echo "<br>";
           //  echo $row['rroom'];
           }
         }

         for($roomCtr = 0 ; $roomCtr < count($arrayRoom) ; $roomCtr++)
         {
           $arrayTemp = array();
         //  echo "<br><br>";
         //  echo $arrayRoom[$roomCtr];
           for($ctrFrom1 = $from ; $ctrFrom1 < $to ; $ctrFrom1++)
           {
             $getStatusQuery = mysql_query("select scheduletable.rstatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'");

             if(mysql_num_rows($getStatusQuery) > 0)
             {
               while($row = mysql_fetch_array($getStatusQuery))
               {
                 $arrayTemp[] = $row['rstatus'];
               }
             }
           }
           if (in_array("Occupied", $arrayTemp) || in_array("Requested", $arrayTemp))
           {

           }
           else
           {
             $arrayVacantRoom[] = $arrayRoom[$roomCtr];
           }
         }

         $ctr = 0;
         for ($showRoomCtr = 0 ; $showRoomCtr < count($arrayVacantRoom) ; $showRoomCtr++)
         {
           echo "<tr>";
           echo "<td>  <input type='submit' name='room[".$ctr."]' class='tableButton' value=$arrayVacantRoom[$showRoomCtr]> </td>";
           echo "</tr>";

            echo "<input type='hidden' name='hiddenname[".$ctr."]' value=$arrayVacantRoom[$showRoomCtr]>";
            echo "<input type='hidden' name='hiddenFrom[".$ctr."]' value=$fromTime>";
            echo "<input type='hidden' name='hiddenTo[".$ctr."]' value=$toTime>";
  					echo "<input type='hidden' name='hiddenFromIndex[".$ctr."]' value=$from>";
            echo "<input type='hidden' name='hiddenToIndex[".$ctr."]' value=$to>";
           $ctr++;
         }
		 }


     /*for($ctrFrom = $from ; $ctrFrom <= $to ; $ctrFrom++)
     {
     $vacantquery = mysql_query("select timetable.tTime, rday, roomtable.rroom, rstatus from scheduletable s join timetable on s.tid = timetable.tid join roomtable on s.rid=roomtable.rid where s.tID = '$ctrFrom' and s.rstatus = 'Vacant' and s.rday = '$day'");

       if(mysql_num_rows($vacantquery) > 0)
       {
         while($row = mysql_fetch_array($vacantquery))
         {
           echo "<tr>";
           echo "<td>" . $row['rroom'] ."</td>";
           echo "</tr>";
         }


       }
     }*/
     echo "</table></center>";
     //echo "</div>";
     echo "</form>";
   }
?>
