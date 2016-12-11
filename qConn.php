<?php
/*CREATED BY ALYSSA GANOTISI AND IDA PENAFLOR*/
	include('connects.php');

	if(!function_exists('SelectUser'))
	{
		function SelectUser($con,$username)
		{

			$query = "SELECT * FROM account where id = '$username'";
	        $result = mysqli_query($con,$query);

	        return $result;
		}
	}

	if(!function_exists('GetRooms'))
	{
		function GetRooms($con,$rtype)
		{
		  if($rtype == "all")
	      {
	        $qAGet = "select * from roomtable";
	        $getRooms = mysqli_query($con,$qAGet); 
	      }
	      else
	      {
	        $qGetRooms = "select * from roomtable where rtype = '$rtype'";
	        $getRooms = mysqli_query($con,$qGetRooms); 
	      }

	      return $getRooms;
		}
	}

	if(!function_exists('GetRStat'))
	{
		function GetRStat($con,$array,$ctrFrom1,$day)
		{
			$qGetStat = "select scheduletable.rStatus from scheduletable join roomtable on scheduletable.rid = roomtable.rid where roomtable.rroom = '$array' and scheduletable.tID = '$ctrFrom1' and scheduletable.rday = '$day'";
	         $getStatusQuery = mysqli_query($con,$qGetStat);

	        return $getStatusQuery;
		}//end
	}

	if(!function_exists('GetRequestSameDate'))
	{
		function GetRequestSameDate($con,$date)
		{
			$qGetRequest = "select * from requests where dateOfUse='$date' and status='Approved' or dateOfUse='$date' and status='Pending'";
	    	$getRequestFromSameDate = mysqli_query($con,$qGetRequest);

	    	return $getRequestFromSameDate;
		}		
	}
	
	if(!function_exists('GetRoomTable'))
	{
		function GetRoomTable($con,$arrayF)
		{
			$qGetType = "select rType from roomtable where rRoom='$arrayF'";
	      $getType = mysqli_query($con,$qGetType);

	      return $getType;
		}
	}

	if(!function_exists('GetFromTime'))
	{
		function GetFromTime($con,$from) //get start time
		{

		    //$qGetFrom = "select tTime from timetable where tid = '$from'";
		    $getFromTime = mysqli_query($con,"select tTime from timetable where tid = '$from'");

		    if(mysqli_num_rows($getFromTime)>0)
		    {
		      while($row = mysqli_fetch_array($getFromTime))
		      {
		        $fromTime = $row['tTime'];
		      } 
		    }

		    return $fromTime;
		}//end
	}

	if(!function_exists('GetToTime'))
	{
		function GetToTime($con,$to) //get end time
		{
		    $toTime = "";
		    $qGetTo = "select tTime from timetable where tid = '$to'";
		    $getToTime = mysqli_query($con,$qGetTo);

		    if(mysqli_num_rows($getToTime)>0)
		    {
		      while($row = mysqli_fetch_array($getToTime))
		      {
		        $toTime = $row['tTime'];
		      }
		    }

		    return $toTime;
		}//end	
	}

	if(!function_exists('ConvertToTid'))
	{
		function ConvertToTid($con,$time)
		{
		    $qGetID = "select tID from timetable where tTime = '$time'";
		    $getTid = mysqli_query($con,$qGetID);

		    if(mysqli_num_rows($getTid)>0)
		    {
		      while($row = mysqli_fetch_array($getTid))
		      {
		        $time = $row['tID'];
		      }
		    }

		    return $time;
		}//end	
	}

	if(!function_exists('UpdatePass'))
	{
		function UpdatePass($con,$newPass,$username)
		{
			$result2 = mysqli_query($con,"UPDATE account set password='$newPass' where id='$username'");
			return $result2;
		}	
	}

	if(!function_exists('GetNotif'))
	{
		function GetNotif($con,$type,$dept,$userid)
		{
			if($type=='Dean')
		    {
			   $getNotifs = mysqli_query($con,"select * from notification join requests on notification.requestID=requests.requestID where notification.isNotified='0' and notification.account='$type' and requests.dept='$dept'");
		    }
		    else if($type=='Staff')
		    {
		        $getNotifs = mysqli_query($con,"select * from notification join requests on notification.requestID=requests.requestID where notification.isNotified='0' and notification.account='$type' and requests.requesterID='$userid'");
		    }
		    else
		    {
		        $getNotifs = mysqli_query($con,"select * from notification where isNotified='0' and account='$type'");
		    }

		    return $getNotifs;
		}//end function	
	}

	if(!function_exists('NotifUpdate'))
	{
		function NotifUpdate($con,$account)
		{
			mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
		}
	}

	if(!function_exists('NotifShow'))
	{
		function NotifShow($con,$account)
		{
			mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
		}
	}

	//MALI PAAAAAAAAA
	if(!function_exists('GetStaffNotif'))
	{
		function GetStaffNotif($con, $output, $account, $countid, $arrayID, $currentdate, $userid, $arrayDept, $arrayFname, $arrayLname,$arrayRequesterID,$arrayStatus, $arrayIsNotified,$arrayTime,$arrayPurpose)
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
	}//end

	if(!function_exists('GetAdminNotif'))
	{
		function GetAdminNotif($con, $output, $account, $countid, $arrayID, $currentdate, $dept, $arrayDept, $arrayFname, $arrayLname,$arrayRequesterID,$arrayStatus, $arrayIsNotified,$arrayTime,$arrayPurpose)
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
	}

	//dv-main
	if(!function_exists('CheckAdmin'))
	{
		function CheckAdmin($con,$type,$dept)
		{
			if($type == 'Dean')
            {
                $getrequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where requests.status='Pending' and action.deanAction='Pending' and requests.dept='$dept' and requests.isExpired=0");
          	}
            else if($type == 'LMO')
            {
                $getrequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where requests.status='Pending' and action.deanAction='Endorsed' and action.lmoAction='Pending' and requests.isExpired=0");
            }
            else if($type == 'CDMO')
            {
                $getrequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where requests.status='Pending' and action.deanAction='Endorsed' and action.cdmoAction='Pending' and action.lmoAction='N/A' or requests.status='Pending' and action.deanAction='Endorsed' and action.cdmoAction='Pending' and action.lmoAction='Approved' and requests.isExpired=0");
            }

            return $getrequests;
		}
	}

	if(!function_exists('GetNames'))
	{
		function GetNames($con,$arrayR)
		{
			$getnames = mysqli_query($con,"select * from account join requests on account.id=requests.requesterID where requests.requesterID='$arrayR'");

			return $getnames;
		}
	}

	//viewReport
	if(!function_exists('CheckIfAdmin'))
	{
		function CheckIfAdmin($con,$department,$type,$month)
		{
			if($department == 'All')
	      	{
		        if($type == 'LMO')
		        {
		          $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%'");
		        }
		        else
		        {
		          $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%'");
		        }
	      }
	      else
	      {
	        if($type == 'LMO')
	        {
	          $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%' and requests.dept='$department'");
	        }
	        else
	        {
	          $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%' and dept='$department'");
	        }
	      }

	      return $getRequests;
		}//end of function
	}

	if(!function_exists('EquipRequest'))
	{
		function EquipRequest($con,$arrayID)
		{
			$query = mysqli_query($con,"select * from equipmentrequest where requestID='$arrayID'");

			return $query;
		}
	}

	//DEAN
	if(!function_exists('UpdateIfApproved'))
	{
		function UpdateIfApproved($con,$action,$actioncol,$requestID,$datecol,$currentdate)
		{
			mysqli_query($con,"UPDATE action set $actioncol='$action', $datecol='$currentdate' where requestID='$requestID'");

                $getlmo = mysqli_query($con,"select lmoAction from action where requestID='$requestID'");

               return $getlmo;
		}
	}

	if(!function_exists('InsertRequest'))
	{
		function InsertRequest($con,$getlmoaction,$requestID)
		{
			if($getlmoaction == 'N/A')
                {
                    $notif = "INSERT into notification values ('$requestID', 'cdmo', '0')";
                    if (!mysqli_query($con,$notif))
                    {
                        die('Error: ' . mysqli_error());
                    }
                }
                else
                {
                    $notif = "INSERT into notification values ('$requestID', 'lmo', '0')";
                    if (!mysqli_query($con,$notif))
                    {
                        die('Error: ' . mysqli_error());
                    }
                }
		}
	}

	if(!function_exists('NotifInsert'))
	{
		function NotifInsert($con,$requestID)
		{
			$notif = "INSERT into notification values ('$requestID', 'staff', '0')";

			return $notif;
		}
	}
	if(!function_exists('UpdateIfApproved'))
	{
		
	}
	if(!function_exists('UpdateIfApproved'))
	{
		
	}

?>