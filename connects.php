<?php

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "mclorrs_db";

$con=mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
@mysql_select_db($DB_NAME) or die( "Unable to select database");
// @mysql_select_db($DB_NAME) or die( "header('location:login.php');");
?>
