<?php 
include('connects.php');
include('qConn.php');

session_start();

	$username = "";
	if (isset($_SESSION['id']))
  	{
  		date_default_timezone_set('Singapore');
	    //$currentdate = date('m/d/Y H:i:s');
  		$currentdate = date('m/d/Y h:i A');


    	$username = $_SESSION['id'];
    	$requestID = $_POST['requestID'];
    	$remarks = $_POST['remarks'];
    	echo $requestID;
    	echo $username;
    	echo $remarks;

    	$sql1 = CancelledRequest($con,$username,$requestID,$remarks,$currentdate);

		if (!mysqli_query($con,$sql1))
		{
			die('Error: ' . mysqli_error());
		}
		
		header("location:viewRequestedRooms.php");
	}
	else
	{
		//header('Location: http://localhost/mclrrs/main.php');
		header("location:main.php");
	}
 ?>