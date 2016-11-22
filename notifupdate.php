<?php
	include('connects.php');

	$account = $_POST['account'];

	mysql_query("UPDATE notification set isNotified='1' where account='$account'");
?>