<?php
	include('connects.php');
	session_start();

	if (isset($_SESSION['id']))
  	{
  		$type = $_SESSION['type'];
  		$ename = $_POST['ename'];
  		$qty = $_POST['qty'];

  		date_default_timezone_set('Singapore');
	    $currentdate = date('m/d/Y H:i:s');

		$sql1 = "INSERT into equipment (ename, edept, qty, onhand, modified, created) values ('$ename', '$type', '$qty', '$qty', '$currentdate', '$currentdate')";

		if (!mysql_query($sql1, $con))
		{
			die('Error: ' . mysql_error());
		}
		else
		{
			//header('Location: http://localhost/mclrrs/viewInventory.php');
			header("location:viewInventory.php");
		}
  	}
?>