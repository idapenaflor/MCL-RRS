<?php
	require('connects.php');
	session_start();

	$arrayID[] = array();
	$type = $_SESSION['type'];
    $userid = $_SESSION['id'];
    $dept = $_SESSION['dept'];

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

	if(mysqli_num_rows($getNotifs) > 0)
    {
        while($row = mysqli_fetch_array($getNotifs))
        {
            $arrayID[] = $row['requestID'];
        }
    }

    $dataNotif['countid'] = count(array_filter($arrayID));
    $dataNotif['account'] = $type;
    $dataNotif['userid'] = $userid;
    $dataNotif['dept'] = $dept;
    echo json_encode($dataNotif);
?>

