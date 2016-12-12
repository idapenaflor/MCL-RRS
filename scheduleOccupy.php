<?php
	include('connects.php');
  include('qConn.php');
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
	    	SchedOccupy($con,$roomName,$arrayDay[$ctr],$arrayTime[$ctr2]);
	    }	
    }
    header("location:schedule.php");
?>