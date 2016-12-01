<?php
	include('connects.php');
	$roomName = $_POST['room'];

	echo $roomName;

	$arrayDay = array();
	$arrayTime = array();

	if(!empty($_POST['day']))
    {
      foreach($_POST['day'] as $day)
      {
        $arrayDay[] = $day;
        echo $day;
      }
    }

    if(!empty($_POST['time']))
    {
      foreach($_POST['time'] as $time)
      {
        $arrayTime[] = $time;
        echo $time;
      }
    }

    for($ctr=0; $ctr<count($arrayDay); $ctr++)
    {
    	for($ctr2=0; $ctr2<count($arrayTime); $ctr2++)
	    {
	    	mysqli_query($con, "UPDATE scheduletable set rStatus='Occupied' where rID='$roomName' and rDay='$arrayDay[$ctr]' and tID='$arrayTime[$ctr2]'");
	    }	
    }
    header("location:schedule.php");
?>