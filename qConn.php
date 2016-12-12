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

	//NOTIFICATION - DI PA NAKALAGAY KASI MAY MALI
	//notif.php
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

	//notifupdate.php
	if(!function_exists('NotifUpdate'))
	{
		function NotifUpdate($con,$account)
		{
			//$up = mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
			mysqli_query($con,"UPDATE notification set isNotified='1' where account='$account'");
			//return $up;
		}
	}

	//notifshow.php
	if(!function_exists('GetAdminNotification'))
	{
		function GetAdminNotification($con,$account,$dept)
		{
			if($account == 'Dean')
			{
				$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account' and requests.dept='$dept'");
			}
			else
			{
				$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account'");
			}

			return $getNotifs;
		}
		
	}//end

	if(!function_exists('GetRequestDetails')) //Query to retrieve names
	{
		function GetRequestDetails($con,$arrayID)
		{
			$getNotifs = mysqli_query($con,"select * from account join requests on account.id=requests.requesterID where requests.requestID='$arrayID'");

			return $getNotifs;
		}
	}

	//QUERY TO GET IF THE NOTIFICATION IS NOTIFIED OR NOT
	if(!function_exists('GetNotifsss'))
	{
		function GetNotifsss($con,$account,$arrayID)
		{
			$isnotify = mysqli_query($con,"select * from notification where requestID='$arrayID' and account='$account'");

			return $isnotify;
		}
	}

	if(!function_exists('DeanTime'))
	{
		function DeanTime($con,$arrayID)
		{
			$getTime = mysqli_query($con,"select dateoffiling from requests where requestID='$arrayID'");
			return $getTime;	
		}
	}

	if(!function_exists('LMOTime'))
	{
		function LMOTime($con,$arrayID)
		{
			$getTime = mysqli_query($con,"select deanDate from action where requestID='$arrayID'");
			return $getTime;	
		}
	}

	if(!function_exists('CDMOTime'))
	{
		function CDMOTime($con,$arrayID)
		{
			$getTime = mysqli_query($con,"select * from action where requestID='$arrayID'");
			return $getTime;	
		}
	}

	if(!function_exists('GetStaffNotification'))
	{
		function GetStaffNotification($con,$account,$userid)
		{
			$getNotifs = mysqli_query($con,"select * from requests join notification on requests.requestID=notification.requestID where notification.account='$account' and requests.requesterID='$userid'");
			return $getNotifs;	
		}
	}

	if(!function_exists('GetStaffApproved'))
	{
		function GetStaffApproved($con,$arrayID)
		{
			$getTime = mysqli_query($con,"select cdmoDate from action where requestID='$arrayID'");

			return $getTime;
		}
	}

	if(!function_exists('GetStaffRejected'))
	{
		function GetStaffRejected($con,$arrayID)
		{
			$getTime = mysqli_query($con,"select * from action where requestID='$arrayID'");

			return $getTime;
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

	//viewReportTable
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

	//DEAN = approverejectrequest
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

			 if (!mysqli_query($con,$notif))
                {
                    die('Error: ' . mysqli_error());
                }
		}
	}
	if(!function_exists('ApprovedRequest'))
	{
		function ApprovedRequest($con,$type,$action,$requestID,$actioncol,$datecol,$currentdate)
		{
			if($type=='CDMO')
            {
               mysqli_query($con,"UPDATE requests set status='$action' where requestID='$requestID'");
            }
            else if($type=='LMO')
            {
                $notif = "INSERT into notification values ('$requestID', 'cdmo', '0')";
                if (!mysqli_query($con,$notif))
                {
                    die('Error: ' . mysqli_error());
                }
            }
            echo $requestID;
            mysqli_query($con, "UPDATE action set $actioncol='$action', $datecol='$currentdate' where requestID='$requestID'");
		}
	}

	if(!function_exists('RejectedRequest'))
	{
		function RejectedRequest($con,$action,$requestID,$actioncol,$datecol,$currentdate,$remarks,$type)
		{
			mysqli_query($con,"UPDATE requests set status='$action' where requestID='$requestID'");
            mysqli_query($con,"UPDATE action set $actioncol='$action', $datecol='$currentdate' where requestID='$requestID'");

            $sql1 = "INSERT into remarks (requestID, type, remarks, rdate) values ('$requestID', '$action', '$remarks', '$currentdate')";

            if (!mysqli_query($con,$sql1))
            {
                die('Error: ' . mysqli_error());
            }

            $notif = "INSERT into notification values ('$requestID', 'staff', '0')";
            if (!mysqli_query($con,$notif))
            {
                die('Error: ' . mysqli_error());
            }
		}
	}
	//CancelRequest.php
	if(!function_exists('CancelledRequest'))
	{
		function CancelledRequest($con,$username,$requestID,$remarks,$currentdate)
		{
			mysqli_query($con,"UPDATE requests set status='Cancelled' where requesterID='$username' and requestID='$requestID'");

    		$sql1 = "INSERT into remarks (requestID, type, remarks, rdate) values ('$requestID', 'Cancelled', '$remarks', '$currentdate')";

    		return $sql1;
		}
	}

	//EDITEQUIPMENTDETAILS.PHP
	if(!function_exists('UpdateEquipmentDetails'))
	{
		function UpdateEquipmentDetails($con,$ename,$qty,$onhand,$currentdate,$id)
		{
			mysqli_query($con,"UPDATE equipment set ename='$ename', qty='$qty', onhand='$onhand', modified='$currentdate' where eid='$id'");
		}
	}

	//ExpiredRequest.php
	if(!function_exists('ExpiredRequest'))
	{
		function ExpiredRequest($con,$arrayID)
		{
			$queryIsExpired = mysqli_query($con,"select isExpired from requests where requestID='$arrayID'");

			return $queryIsExpired;
		}//end of function
	}

	if(!function_exists('UpdateExpiredRequest'))
	{
		function UpdateExpiredRequest($con,$arrayID)
		{
			mysqli_query($con,"UPDATE requests set isExpired='1' where requestID='$arrayID'");
		            
		    $notif = "INSERT into notification values ('$arrayID', 'staff', '0')";

		    return $notif;
		}//end of function
	}

	//requestRoom.php
	if(!function_exists('InsertRequestedRoom'))
	{
		function InsertRequestedRoom($con,$username,$dept,$currentdate,$purpose,$dateofuse,$from,$to,$room,$dean,$cdmo,$lmo)
		{
			$sql1 = "INSERT into requesttable (requesterID, collegedept, dateoffiling, purposeofactivity, dateofuse, timeFrom, timeTo, roomuse, dean, cdmo, lmo, isNotified) values ('$username', '$dept', '$currentdate', '$purpose', '$dateofuse', '$from', '$to', '$room', '$dean', '$cdmo', '$lmo', '0')";

			return $sql1;
		}
	}

	//requestRoomModal.php
	if(!function_exists('EquipmentRequests'))
	{
		function EquipmentRequests($con,$equipment)
		{
			$query = mysqli_query($con,"select * from equipment where ename='$equipment'");

			return $query;
		}
	}

	if(!function_exists('InsertRequestDetails'))
	{
		function InsertRequestDetails($con,$username,$dept,$currentdate,$purpose,$dateofuse,$fromTime,$toTime,$room)
		{
			//QUERY TO INSERT REQUEST DETAILS IN REQUESTS TABLE
    		$sql1 = "INSERT into requests (requesterID, dept, dateoffiling, purpose, dateofuse, timeFrom, timeTo, room, status, isExpired) values ('$username', '$dept', '$currentdate', '$purpose', '$dateofuse', '$fromTime', '$toTime', '$room', 'Pending', '0')";

    		return $sql1;
		}//end of function
	} //end

	if(!function_exists('GetLatestID'))
	{
		function GetLatestID($con,$username,$requestID,$dean,$cdmo,$lmo)
		{
			//QUERY TO GET THE REQUEST ID OF THE LATEST REQUEST OF THE USER
		      $sql2 = mysqli_query($con,"SELECT requestID FROM requests where requesterID='$username' ORDER BY requestID DESC LIMIT 1");

		      if(mysqli_num_rows($sql2)>0)
		      {
		        while($row = mysqli_fetch_array($sql2))
		        {
		          $requestID = $row['requestID'];
		        } 
		      }

		      //QUERY TO INSERT THE EQUIPMENT TO THE EQUIPMENTREQUEST TABLE
		      $sql3 = "INSERT into action (requestID, deanAction, cdmoAction, lmoAction) values ('$requestID', '$dean', '$cdmo', '$lmo')";

		      if (!mysqli_query($con,$sql3))
		      {
		        die('Error: ' . mysqli_error());
		      }

		      $sql5 = "INSERT into notification values ('$requestID', 'dean', '0')";

		       if (!mysqli_query($con,$sql5))
		          {
		            die('Error: ' . mysqli_error());
		          }
		}//end of function
	}

	if(!function_exists('InsertEquipRequest'))
	{
		function InsertEquipRequest($con,$requestID,$arrayEquipment,$arrayQty)
		{
			$sql = "INSERT into equipmentrequest (requestID, ename, qty) values ('$requestID', '$arrayEquipment', '$arrayQty')";

			return $sql4;
		}
	}

	if(!function_exists('InsertNotifications'))
	{
		function InsertNotifications($con,$requestID)
		{
			$sql5 = "INSERT into notification values ('$requestID', 'dean', '0')";

			 if (!mysqli_query($con,$sql5))
		      {
		        die('Error: ' . mysqli_error());
		      }
		}
	}

	if(!function_exists('InsertNewEquip'))
	{
		function InsertNewEquip($con,$ename,$type,$qty,$qty,$currentdate,$currentdate)
		{
			$sql1 = "INSERT into equipment (ename, edept, qty, onhand, modified, created) values ('$ename', '$type', '$qty', '$qty', '$currentdate', '$currentdate')";

			return $sql1;	
		}
	}

	//viewDetailsModal.php
	if(!function_exists('ViewRequestDetails'))
	{
		function ViewRequestDetails($con,$requestID)
		{
			$query1 = mysqli_query($con,"select * from requests where requestID='$requestID'");
			return $query1;
		}//end of function
	}
	if(!function_exists('ViewActionDetails'))
	{
		function ViewActionDetails($con,$requestID)
		{
			$query = mysqli_query($con,"select * from action where requestID='$requestID'");
			return $query;
		}//end of function
	}
	if(!function_exists('ViewRequestDetailsRemarks'))
	{
		function ViewRequestDetailsRemarks($con,$requestID)
		{
			$query = mysqli_query($con,"select * from remarks where requestID='$requestID'");
			return $query;
		}//end of function
	}

	//viewEditInventoryModal
	if(!function_exists('EditInventory'))
	{
		function EditInventory($con,$equipID)
		{
			$getEquipment = mysqli_query($con,"select * from equipment where eid='$equipID'");
			return $getEquipment;
		}//end of function
	}

	//viewEquipmentModal.php
	if(!function_exists('ViewEquipment'))
	{
		function ViewEquipment($con,$requestID)
		{
			$query = mysqli_query($con,"select * from equipmentrequest where requestID='$requestID'");
			return $query;
		}//end of function
	}

	//viewInventory.php
	if(!function_exists('ViewEquipPerType'))
	{
		function ViewEquipPerType($con,$type)
		{
			$getEquipment = mysqli_query($con,"select * from equipment where edept='$type'");
			return $getEquipment;
		}//end of function
	}

	//viewmodal.php
	if(!function_exists('ViewAllEquip'))
	{
		function ViewAllEquip($con)
		{
			$qGetAll = "select * from equipment";
			$query = mysqli_query($con,$qGetAll);

			return $query;
		}//end of function
	}

	if(!function_exists('SelectSimilarRequest'))
	{
		function SelectSimilarRequest($con,$date)
		{
			//GET REQUESTS ID OF REQUEST WITH SIMILAR DATE OF USE
	    	$queryGetSimilarRequest = mysqli_query($con,"select * from requests where dateOfUse='$date' and status='Approved' or dateOfUse='$date' and status='Pending'");

			return $queryGetSimilarRequest;
		}//end of function
	}

	if(!function_exists('SelectEquipRequest'))
	{
		function SelectEquipRequest($con,$finalId,$arrayEquipments)
		{
			$query = mysqli_query($con,"select * from equipmentrequest where requestID='$finalId' and ename='$arrayEquipments'");

			return $query;
		}//end of function
	}

	//================FOR REPORT=================
	//viewReport.php
	if(!function_exists('SelectRequestsForReport'))
	{
		function SelectRequestsForReport($con,$type,$month)
		{
			if($type == 'LMO')
		    {
		        $getRequests = mysqli_query($con,"select * from requests join action on requests.requestID=action.requestID where action.lmoAction!='N/A' and requests.status='Approved' and requests.dateOfUse like '$month%'");
		    }
		    else
		    {
		        $getRequests = mysqli_query($con,"select * from requests where status='Approved' and dateOfUse like '$month%'");
		    }

		    return $getRequests;
		}//end of function
	}

	//printPermit.php
	if(!function_exists('GetDeanName'))
	{
		function GetDeanName($con,$dept)
		{
			$query1 = mysqli_query($con, "select * from account where type='dean' and dept='$dept'");

			return $query1;	
		}//end of function
	}

	if(!function_exists('SelectCDMO'))
	{
		function SelectCDMO($con)
		{
			$query2 = mysqli_query($con, "select * from account where type='cdmo'");

			return $query2;	
		}//end of function
	}

	if(!function_exists('SelectAction'))
	{
		function SelectAction($con,$id)
		{
			$query4 = mysqli_query($con, "select * from action where requestID='$id'");

			return $query4;	
		}//end of function
	}

	if(!function_exists('SelectLMO'))
	{
		function SelectLMO($con)
		{
			$query3 = mysqli_query($con, "select * from account where type='lmo'");
			return $query3;
		}//end of function
	}

	if(!function_exists('SelectRoomType'))
	{
		function SelectRoomType($con,$room)
		{
			$query1 = mysqli_query($con, "select rType from roomtable where rRoom='$room'");
			return $query1;
		}//end of function
	}

	if(!function_exists('SelectShowEquip'))
	{
		function SelectShowEquip($con,$id)
		{
			$query1 = mysqli_query($con, "select * from equipmentrequest where requestID='$id'");
			return $query1;
		}//end of function
	}

	if(!function_exists('SelectEquipToDisplay'))
	{
		function SelectEquipToDisplay($con,$arrayOthers)
		{
			$query1 = mysqli_query($con, "select edept from equipment where ename='$arrayOthers'");
			return $query1;
		}//end of function
	}

	//viewRequestedRooms.php
	if(!function_exists('GetAllUserRequest'))
	{
		function GetAllUserRequest($con,$username)
		{
			$getRequests = mysqli_query($con,"select * from requests where requesterID='$username'");
			return $getRequests;
		}//end of function
	}

	//================FOR BACKEND - OITS =================
	//signup.php
	if(!function_exists('InsertNewAccount'))
	{
		function InsertNewAccount($con,$username,$StorePass,$utype,$fname,$lname,$mname,$department)
		{
			$sql1="INSERT INTO account VALUES('$username','$StorePass', '$utype', '$fname', '$lname', '$mname', '$department')";	
			return $sql1;
		}
	}

	//schedule.php
	if(!function_exists('SelectRooms'))
	{
		function SelectRooms($con)
		{
			$query1 = mysqli_query($con,"select * from roomtable");	
			return $query1;
		}
	}

	//scheduleOccupy.php
	if(!function_exists('SchedOccupy'))
	{
		function SchedOccupy($con,$roomName,$arrayDay,$arrayTime)
		{
			mysqli_query($con, "UPDATE scheduletable set rStatus='Occupied' where rID='$roomName' and rDay='$arrayDay' and tID='$arrayTime'");
		}
	}

	//query.php
	if(!function_exists('SelectRoomID'))
	{
		function SelectRoomID($con)
		{
			$query1 = mysqli_query($con,"select rID from roomtable");
			return $query1;
		}
	}

	if(!function_exists('SchedValues'))
	{
		function SchedValues($con,$y,$day,$room)
		{
			$sql1="insert into scheduletable values ('$y','$day','$room','Vacant')";
			return $sql1;
		}
	}
?>