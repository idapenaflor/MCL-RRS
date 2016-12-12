<?php
    include('connects.php');
    include('qConn.php');

    date_default_timezone_set('Singapore');
    $currentdate = date('m/d/Y');

    $username = $_SESSION['id'];

    $arrayID = array();
    $arrayIsExpired = array();
    $arrayDateOfUse = array();

    //ExpiredRequest($con,$username,$arrayID);
    $getRequests = GetAllUserRequest($con,$username);

		    if(mysqli_num_rows($getRequests) > 0)
		    {
		        while($row = mysqli_fetch_array($getRequests))
		        {
		            if($row['dateOfUse'] < $currentdate)
		            {
		                $arrayID[] = $row['requestID'];
		            }            
		        }
		    }

		    for($ctr=0; $ctr<count($arrayID); $ctr++)
		    {
		        $temp = '';

		        $queryIsExpired = ExpiredRequest($con,$arrayID[$ctr]);

		        if(mysqli_num_rows($queryIsExpired)>0)
		        {
		          while($row = mysqli_fetch_array($queryIsExpired))
		          {
		            $temp = $row['isExpired'];
		          } 
		        }

		        if($temp == 0)
		        {
		            $notif = UpdateExpiredRequest($con,$arrayID[$ctr]);
		            if (!mysqli_query($con,$notif)) 
		            {
		                die('Error: ' . mysqli_error());
		            }
		        }
		        
		    }
?>