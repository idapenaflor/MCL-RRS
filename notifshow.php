<?php
	require('connects.php');

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
		$output = GetStaffNotif($con, $output, $account, $countid, $arrayID, $currentdate, $userid);
	}
	else
	{
		$output = GetAdminNotif($con,$output, $account, $countid, $arrayID, $currentdate, $dept);
	}
	

    echo $output;


	function GetAdminNotif($con, $output, $account, $countid, $arrayID, $currentdate, $dept)
	{
		if($account == 'Dean')
		{
			$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account' and requests.dept='$dept'");
		}
		else
		{
			$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account'");
		}
		if(mysqli_num_rows($getNotifs) > 0)
	    {
	        while($row = mysqli_fetch_array($getNotifs))
	        {
	            $arrayID[] = $row['requestID'];
	            $arrayDept[] = $row['dept'];
	        }
	    }

	    //LOOP TO GET THE REQUESTER NAME, ISNOTIFIED, TIME
	    for($ctr=0; $ctr<count($arrayID); $ctr++)
	    {
	    	//QUERY TO GET THE NAMES
	    	$getNotifs = mysqli_query($con,"select * from account join requests on account.id=requests.requesterID where requests.requestID='$arrayID[$ctr]'");

			if(mysqli_num_rows($getNotifs) > 0)
		    {
		        while($row = mysqli_fetch_array($getNotifs))
		        {
		            $arrayFname[] = $row['fname'];
		            $arrayLname[] = $row['lname'];
		        }
		    }


		    //QUERY TO GET IF THE NOTIFICATION IS NOTIFIED OR NOT
		    $isnotify = mysqli_query($con,"select * from notification where requestID='$arrayID[$ctr]' and account='$account'");

			if(mysqli_num_rows($isnotify) > 0)
		    {
		        while($row = mysqli_fetch_array($isnotify))
		        {
		            $arrayIsNotified[] = $row['isNotified'];
		        }
		    }

		    /* QUERIES TO GET THE TIME WHEN ACTION TOOK PLACE
		    	Dean: Get date from dateoffiling
		    	LMO: Get deanDate from action
		    	CDMO: Get deanDate or lmoDate
		    */

		    switch($account)
		    {
		    	case 'Dean':
		    	{
		    		$getTime = mysqli_query($con,"select dateoffiling from requests where requestID='$arrayID[$ctr]'");

		    		if(mysqli_num_rows($getTime) > 0)
				    {
				        while($row = mysqli_fetch_array($getTime))
				        {
				            $arrayTime[] = $row['dateoffiling'];
				        }
				    }
		    		break;
		    	}

		    	case 'LMO':
		    	{
		    		$getTime = mysqli_query($con,"select deanDate from action where requestID='$arrayID[$ctr]'");

		    		if(mysqli_num_rows($getTime) > 0)
				    {
				        while($row = mysqli_fetch_array($getTime))
				        {
				            $arrayTime[] = $row['deanDate'];
				        }
				    }
		    		break;
		    	}

		    	case 'CDMO':
		    	{
		    		$getTime = mysqli_query($con,"select * from action where requestID='$arrayID[$ctr]'");

		    		if(mysqli_num_rows($getTime) > 0)
				    {
				        while($row = mysqli_fetch_array($getTime))
				        {
				            if($row['lmoAction'] == 'N/A')
				            {
				            	$arrayTime[] = $row['deanDate'];
				            }
				            else
				            {
				            	$arrayTime[] = $row['lmoDate'];
				            }
				        }
				    }

		    		break;
		    	}
		    }
	    }

	    if($countid == 0)
	    {
	    	$output .="
			<li class='header notif-header'>
				<span>No new notifications.</span>
				<span class='pull-right-container'>
					<span class='label label-primary pull-right' style='font-size:14px'>$currentdate</span>
			</li>
	    	";
	    }
	    else
	    {
	    	$output .="
			<li class='header notif-header'>
				<span>You have $countid notification/s.</span>
				<span class='pull-right-container'>
					<span class='label label-primary pull-right' style='font-size:14px'>$currentdate</span>
			</li>
	    	";
	    }
	    
	    //LOOP TO DISPLAY
	    for($ctr=count($arrayID)-1; $ctr>=0; $ctr--)
	    {
	    	$getTime = strtotime($arrayTime[$ctr]);
			$time = date('h:i A', $getTime);

			$getDate = strtotime($arrayTime[$ctr]);
			$date = date('m/d/Y', $getDate);


			if($date == $currentdate)
			{
				if($arrayIsNotified[$ctr] == 0)
		    	{
		    		$style = "style=background-color:#e0e0e0";
		    	}
		    	else
		    	{
		    		$style = '';
		    	}

		    	$output .="
					<li $style>
						<a href='dv-main.php'>
							<i class='fa fa-user'></i>
							$arrayDept[$ctr] - New request from $arrayFname[$ctr] $arrayLname[$ctr]
							<br/>
							$time
						</a>
					</li>
		    		";
				}
	    }

	    return $output;
	}

	function GetStaffNotif($con, $output, $account, $countid, $arrayID, $currentdate, $userid)
	{
		$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account' and requests.requesterID='$userid'");

		if(mysqli_num_rows($getNotifs) > 0)
	    {
	        while($row = mysqli_fetch_array($getNotifs))
	        {
	            if (in_array($row['requestID'], $arrayID))
			    {

			    }
			    else
			    {
			    	$arrayID[] = $row['requestID'];
	            	$arrayPurpose[] = $row['purpose'];

			    	if($row['isExpired'] == 1)
		            {
		            	$arrayStatus[] = 'Expired';
		            }
		            else
		            {
		            	$arrayStatus[] = $row['status'];
		        	}
			    }
	            
	        }
	    }

	    //echo count($arrayID);
	    for($ctr=0; $ctr<count($arrayID); $ctr++)
	    {
	    	//QUERY TO GET IF THE NOTIFICATION IS NOTIFIED OR NOT
		    $isnotify = mysqli_query($con,"select * from notification where requestID='$arrayID[$ctr]' and account='$account'");

			if(mysqli_num_rows($isnotify) > 0)
		    {
		        while($row = mysqli_fetch_array($isnotify))
		        {
		            $arrayIsNotified[] = $row['isNotified'];
		        }
		    }

	    	if($arrayStatus[$ctr] == 'Approved')
	    	{
	    		$getTime = mysqli_query($con,"select cdmoDate from action where requestID='$arrayID[$ctr]'");

	    		if(mysqli_num_rows($getTime) > 0)
			    {
			        while($row = mysqli_fetch_array($getTime))
			        {
			            $arrayTime[] = $row['cdmoDate'];
			        }
			    }
	    	}
	    	else if($arrayStatus[$ctr] == 'Rejected')
	    	{
	    		$getTime = mysqli_query($con,"select * from action where requestID='$arrayID[$ctr]'");

	    		if(mysqli_num_rows($getTime) > 0)
			    {
			        while($row = mysqli_fetch_array($getTime))
			        {
			            if($row['deanAction'] == 'Rejected')
			            {
			            	$arrayTime[] = $row['deanDate'];
			            }
			            if($row['lmoAction'] == 'Rejected')
			            {
			            	$arrayTime[] = $row['lmoDate'];
			            }
			            if($row['cdmoAction'] == 'Rejected')
			            {
			            	$arrayTime[] = $row['cdmoDate'];
			            }
			        }
			    }
	    	}
	    	else
	    	{
	    		$currenttime = date('m/d/Y h:i A');
	    		$arrayTime[] = $currenttime;
	    	}
	    }

	    if($countid == 0)
	    {
	    	$output .="
			<li class='header notif-header'>
				<span>No new notifications.</span>
				<span class='pull-right-container'>
					<span class='label label-primary pull-right' style='font-size:14px'>$currentdate</span>
			</li>
	    	";
	    }
	    else
	    {
	    	$output .="
			<li class='header notif-header'>
				<span>You have $countid notification/s.</span>
				<span class='pull-right-container'>
					<span class='label label-primary pull-right' style='font-size:14px'>$currentdate</span>
			</li>
	    	";
	    }

	    //LOOP TO DISPLAY
	    for($ctr=count($arrayID)-1; $ctr>=0; $ctr--)
	    {
	    	$getTime = strtotime($arrayTime[$ctr]);
			$time = date('h:i A', $getTime);

			$getDate = strtotime($arrayTime[$ctr]);
			$date = date('m/d/Y', $getDate);

			if($date==$currentdate)
			{
		    	if($arrayIsNotified[$ctr] == 0)
		    	{
		    		$style = "style=background-color:#e0e0e0";
		    	}
		    	else
		    	{
		    		$style = '';
		    	}

		    	if($arrayStatus[$ctr] == 'Approved')
		    	{	
		    		$output .="
					<li>
						<a href='viewRequestedRooms.php'>
							<i class='fa fa-check-circle' style='color:#5cb85c'></i>
							Request for <b>$arrayPurpose[$ctr]</b> has been approved!
							<br/>
							$time
						</a>
					</li>
		    		";
		    	}
		    	else if($arrayStatus[$ctr] == 'Rejected')
		    	{
		    		$output .="
					<li>
						<a href='viewRequestedRooms.php' class='view-details' id='$arrayID[$ctr]'>
							<i class='fa fa-minus-circle' style='color:#d9534f'></i>
							Request for <b>$arrayPurpose[$ctr]</b> has been rejected.
							<br/>
							$time
						</a>
					</li>
		    		";
		    	}
		    	else if($arrayStatus[$ctr] == 'Expired')
		    	{
		    		$output .="
					<li>
						<a href=#>
							<i class='fa fa-warning' style='color:#FF8800'></i>
							Request for <b>$arrayPurpose[$ctr]</b> has expired.
							<br/>
							$time
						</a>
					</li>
		    		";
		    	}
	    	}
	    }

	    return $output;
	}
?>
<script src="./js/modal-requested-room.js"></script>