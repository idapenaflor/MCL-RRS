<?php
	require('connects.php');
	include('log-auth.php');
	include('qConn.php');

	$account = $_POST['account'];

	//$up = NotifUpdate($con,$account);
	NotifUpdate($con,$account);
	//mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
?>