<?php

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "mclccisn_rrs";

// $con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);
// @mysqli_select_db($DB_NAME) or die( "Unable to select database");
// @mysql_select_db($DB_NAME) or die( "header('location:login.php');");


// $DB_HOST = "localhost";
// $DB_USER = "mclccisn_fgprrs";
// $DB_PASS = "qwerty123";
// $DB_NAME = "mclccisn_rrs";

$con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME) or die( "Unable to select database");


?>
