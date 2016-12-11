<?php
	require('connects.php');
	include('qConn.php');

	$account = $_POST['account'];

	NotifUpdate($con,$account);
?>