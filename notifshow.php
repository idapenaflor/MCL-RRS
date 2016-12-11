<?php
	require('connects.php');
	include('qConn.php');

	date_default_timezone_set('Singapore');
    $currentdate = date('m/d/Y');
    
	$account = $_POST['account'];
	$countid = $_POST['countid'];
	$userid = $_POST['userid'];
	$dept = $_POST['dept'];

	$arrayDept = array();
	$arrayID = array();
	$arrayFname = array();
	$arrayLname = array();
	$arrayRequesterID = array();
	$arrayStatus = array();
	$arrayIsNotified = array();
	$arrayTime = array();
	$arrayPurpose = array();

	$output = '';

	if($account == 'Staff')
	{
		$output = GetStaffNotif($con, $output, $account, $countid, $arrayID, $currentdate, $userid, $arrayDept, $arrayFname, $arrayLname,$arrayRequesterID,$arrayStatus, $arrayIsNotified,$arrayTime,$arrayPurpose);
	}
	else
	{
		$output = GetAdminNotif($con,$output, $account, $countid, $arrayID, $currentdate, $dept, $arrayDept, $arrayFname, $arrayLname,$arrayRequesterID,$arrayStatus, $arrayIsNotified,$arrayTime,$arrayPurpose);
	}
	

    echo $output;
?>
<script src="./js/modal-requested-room.js"></script>