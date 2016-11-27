<?php
	require('connects.php');

	$account = $_POST['account'];

	mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
?>