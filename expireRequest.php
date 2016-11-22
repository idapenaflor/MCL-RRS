<?php
    include('connects.php');

    date_default_timezone_set('Singapore');
    $currentdate = date('m/d/Y');

    $username = $_SESSION['id'];

    $arrayID = array();
    $arrayIsExpired = array();
   // $arrayDateOfUse = array();

    $getRequests = mysql_query("select * from requests where requesterID='$username'");
    if(mysql_num_rows($getRequests) > 0)
    {
        while($row = mysql_fetch_array($getRequests))
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

        $queryIsExpired = mysql_query("select isExpired from requests where requestID='$arrayID[$ctr]'");

        if(mysql_num_rows($queryIsExpired)>0)
        {
          while($row = mysql_fetch_array($queryIsExpired))
          {
            $temp = $row['isExpired'];
          } 
        }

        if($temp == 0)
        {
            mysql_query("UPDATE requests set isExpired='1' where requestID='$arrayID[$ctr]'");
            
            $notif = "INSERT into notification values ('$arrayID[$ctr]', 'staff', '0')";
            if (!mysql_query($notif, $con)) 
            {
                die('Error: ' . mysql_error());
            }
        }
        
    }
?>