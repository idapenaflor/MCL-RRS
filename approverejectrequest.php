<?php 
require('connects.php');
include('log-auth.php');
include('qConn.php');

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

                
                $getlmo = UpdateIfApproved($con,$action,$actioncol,$requestID,$datecol,$currentdate);

                if(mysqli_num_rows($getlmo) > 0)
                {
                    while($row = mysqli_fetch_array($getlmo))
                    {
                        $getlmoaction = $row['lmoAction'];
                    }
                }  

                //QUERY TO INSERT THE REQUEST TO THE NOTIFICATION TABLE
                InsertRequest($con,$getlmoaction,$requestID);
                
            }
        }
        else if($type=='CDMO')
        {
            NotifInsert($con,$requestID);
               
        }


        if($action == 'Approved')
        {
            ApprovedRequest($con,$type,$action,$requestID,$actioncol,$datecol,$currentdate);
        }
        else if($action == 'Rejected')
        {
            RejectedRequest($con,$action,$requestID,$actioncol,$datecol,$currentdate,$remarks,$type);
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

