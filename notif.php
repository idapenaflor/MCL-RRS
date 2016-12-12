<?php
	require('connects.php');
    include('log-auth.php');
    include('qConn.php');
	//session_start();

	$arrayID[] = array();
	$type = $_SESSION['type'];
    $userid = $_SESSION['id'];
    $dept = $_SESSION['dept'];

    $getNotifs = GetNotif($con,$type,$dept,$userid);

	if(mysqli_num_rows($getNotifs) > 0)
    {
        while($row = mysqli_fetch_array($getNotifs))
        {
            $arrayID[] = $row['requestID'];
        }
    }

    //NEED TO HASH THIS
    $dataNotif['countid'] = count(array_filter($arrayID));
    $dataNotif['account'] = $type;
    $dataNotif['userid'] = $userid;
    $dataNotif['dept'] = $dept;
    echo json_encode($dataNotif);
?>

