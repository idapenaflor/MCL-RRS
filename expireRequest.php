<?php
    include('connects.php');

    date_default_timezone_set('Singapore');
    $currentdate = date('m/d/Y');

    $username = $_SESSION['id'];

    $arrayID = array();
    $arrayIsExpired = array();
   // $arrayDateOfUse = array();

    $getRequests = mysqli_query($con,"select * from requests where requesterID='$username'");
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

        $queryIsExpired = mysqli_query($con,"select isExpired from requests where requestID='$arrayID[$ctr]'");

        if(mysqli_num_rows($queryIsExpired)>0)
        {
          while($row = mysqli_fetch_array($queryIsExpired))
          {
            $temp = $row['isExpired'];
          } 
        }

        if($temp == 0)
        {
            mysqli_query($con,"UPDATE requests set isExpired='1' where requestID='$arrayID[$ctr]'");
            
            $notif = "INSERT into notification values ('$arrayID[$ctr]', 'staff', '0')";
            if (!mysqli_query($con,$notif)) 
            {
                die('Error: ' . mysqli_error());
            }
        }
        
    }
?>