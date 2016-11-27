<form action='requestRoom.php' method='post'>

</form>
<?php
	include('connects.php');

	date_default_timezone_set('Singapore');

    $current_date = date('m/d/Y');

	if (isset($_POST['btnSearch']))
	{
		echo "<script language='Javascript'>document.getElementById('rt').innerHTML = '';</script>";
		
		date_default_timezone_set("Asia/Singapore");
		$from = $_POST['cmbFrom'];
		$to = $_POST['cmbTo'];

		//ARRAY FOR GETTING ALL ROOMS
		$arrayRoom = array();
		$arrayType = array();
		$arrayDesc = array();

		//$rtype = $_POST['roomType'];
		$date = $_POST['datetimepicker'];
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
			$qASelect = "select * from roomtable";
		    $getRooms = mysqli_query($con,$qASelect);
		    if(mysqli_num_rows($getRooms) > 0)
		    {
		        while($row = mysqli_fetch_array($getRooms))
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
		        	$qSched = "select scheduletable.rStatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$arrayRoom[$roomCtr]' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'";
		           	$getStatusQuery = mysqli_query($con,$qSched);

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
	           		$arrayVacantType[] = $arrayType[$roomCtr];
	           		$arrayVacantDesc[] = $arrayDesc[$roomCtr];
	        	}
	       	}
			
		    echo "<form action='requestRoom.php' method='post'>";

			$fromTime = GetFromTime($from);
			$toTime = GetToTime($to);

			echo "<tbody style='width:630px;height:330pt;display:block;overflow-y:auto'>";
			for($ctr = 0 ; $ctr < count($arrayVacantRoom) ; $ctr++)
		   	{
		   		echo "<tr>";
		        echo "<td style='padding-left:75pt;padding-right: 75pt;text-align:center;'>$arrayVacantRoom[$ctr]</td>";
		        echo "<td style='padding-left:70pt;padding-right:70pt;'>$arrayVacantType[$ctr]</td>";
		        echo "<td style='padding-left:70pt;padding-right:70pt;text-align:center;'><a href='#' class='btn-block btn-success view-data' name='$arrayVacantType[$ctr]' id='$arrayVacantRoom[$ctr]'><span class='glyphicon glyphicon-plus view-data' title='Request Room'></span></a></td>";
		        echo "</tr>";

		   	}
		   	echo "</tbody>";
		}
	}

	//FUNCTIONS HERE
	function GetFromTime($from) //get start time
	{
		$qGetFrom = "select tTime from timetable where tid = '$from'";
   		$getFromTime = mysqli_query($con,$qGetFrom);

        if(mysqli_num_rows($getFromTime)>0)
        {
	        while($row = mysqli_fetch_array($getFromTime))
	        {
	        	$fromTime = $row['tTime'];
	        }	
        }

        return $fromTime;
	}

	function GetToTime($to) //get end time
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

?>