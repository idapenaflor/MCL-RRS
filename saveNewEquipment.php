<?php
	require('connects.php');
	include('qConn.php');

	session_start();

	if (isset($_SESSION['id']))
  	{
  		$type = $_SESSION['type'];
  		$ename = $_POST['ename'];
  		$qty = $_POST['qty'];

  		date_default_timezone_set('Singapore');
	    $currentdate = date('m/d/Y H:i:s');

		
	    $sql1 = InsertNewEquip($con,$ename,$type,$qty,$qty,$currentdate,$currentdate);
		if (!mysqli_query($con,$sql1))
		{
			die('Error: ' . mysqli_error());
		}
		else
		{
			//header('Location: http://localhost/mclrrs/viewInventory.php');
			header("location:viewInventory.php");
		}
  	}
?>