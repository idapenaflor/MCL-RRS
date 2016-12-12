<?php
	include('connects.php');
	include('qConn.php');

	$id = $_POST['id'];
	$ename = $_POST['ename'];
	$qty = $_POST['qty'];
	$onhand = $_POST['onhand'];

	date_default_timezone_set('Singapore');
	$currentdate = date('m/d/Y H:i:s');

	echo $currentdate;
	echo $onhand;
	
	UpdateEquipmentDetails($con,$ename,$qty,$onhand,$currentdate,$id);
	//header('Location: http://localhost/mclrrs/viewInventory.php');
	header("location:viewInventory.php");
?>