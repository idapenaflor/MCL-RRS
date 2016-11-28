<?php 
require('connects.php');
session_start();
    $username = "";
    if (isset($_SESSION['id']))
    {
        $username = $_SESSION['id'];
        $type = $_SESSION['type'];


        $requestID = $_POST['requestID'];
        $remarks = $_POST['remarks'];
        $action = $_POST['action'];

        echo $action;
        echo $remarks;
        echo $requestID;

        date_default_timezone_set('Singapore');
        $currentdate = date('m/d/Y h:i A');

        $actioncol = $type . 'Action';
        $datecol = $type . 'Date';
        $getlmoaction = '';


        echo $actioncol;
        echo $datecol;
        //echo $roomtype;

        
        if($type=='Dean')
        {
            if($action=='Approved')
            {
                $action = 'Endorsed';

                mysqli_query($con,"UPDATE action set $actioncol='$action', $datecol='$currentdate' where requestID='$requestID'");

                $getlmo = mysqli_query($con,"select lmoAction from action where requestID='$requestID'");

                if(mysqli_num_rows($getlmo) > 0)
                {
                    while($row = mysqli_fetch_array($getlmo))
                    {
                        $getlmoaction = $row['lmoAction'];
                    }
                }  

                //QUERY TO INSERT THE REQUEST TO THE NOTIFICATION TABLE
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
        else if($type=='CDMO')
        {
            $notif = "INSERT into notification values ('$requestID', 'staff', '0')";
                if (!mysqli_query($con,$notif))
                {
                    die('Error: ' . mysqli_error());
                }
        }


        if($action == 'Approved')
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
        else if($action == 'Rejected')
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
        
        //header('Location: http://localhost/mclrrs/dv-main.php');
        header("location:dv-main.php");
    }
    else
    {
        //header('Location: http://localhost/mclrrs/dv-main.php');
        header("location:dv-main.php");
    }
 ?>

