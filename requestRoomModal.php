<!-- THIS IS USED TO INSERT REQUEST DETAILS INTO THE DATABASE -->
<!-- ANDITO DIN UNG PAGKUHA NG MGA VALUES FROM EQUIPMENT -->

<?php 
include('connects.php');
include_once('log-auth.php');

$dean = 'Pending';
$cdmo = 'Pending';
$lmo = 'Pending';

  if (isset($_SESSION['id']))
  {
    date_default_timezone_set('Singapore');
     $currentdate = date('m/d/Y h:i A');

    $username = $_SESSION['id'];

    $room = $_POST['room'];
    $rtype = $_POST['rtype'];
    $dateofuse = $_POST['date'];
    $fromTime = $_POST['fromTime'];
    $toTime = $_POST['toTime'];
    $purpose = $_POST['purpose'];

    $arrayEquipment = array();
    $arrayQty = array();
    $arrayEdept = array();

    $requestID = "";

    if(!empty($_POST['equipment']))
    {
      foreach($_POST['equipment'] as $equipment)
      {
        $arrayEquipment[] = $equipment;

        $query = mysql_query("select * from equipment where ename='$equipment'");

        if(mysql_num_rows($query)>0)
        {
          while($row = mysql_fetch_array($query))
          {
            $arrayEdept[] = $row['edept'];
          } 
        }
      }

      foreach($_POST['qty'] as $qty)
      {
        $arrayQty[] = $qty;
      }

    }

    if($rtype != "Laboratory")
    {
      if (in_array("LMO", $arrayEdept))
      {

      }
      else
      {
        $lmo = "N/A";
      }
    }

    //QUERY TO INSERT REQUEST DETAILS IN REQUESTS TABLE
    $sql1 = "INSERT into requests (requesterID, dept, dateoffiling, purpose, dateofuse, timeFrom, timeTo, room, status, isExpired) values ('$username', '$dept', '$currentdate', '$purpose', '$dateofuse', '$fromTime', '$toTime', '$room', 'Pending', '0')";

    if (!mysql_query($sql1, $con))
    {
      die('Error: ' . mysql_error());
    }
    else
    {
      //QUERY TO GET THE REQUEST ID OF THE LATEST REQUEST OF THE USER
      $sql2 = mysql_query("SELECT requestID FROM requests where requesterID='$username' ORDER BY requestID DESC LIMIT 1");

      if(mysql_num_rows($sql2)>0)
      {
        while($row = mysql_fetch_array($sql2))
        {
          $requestID = $row['requestID'];
        } 
      }

      //QUERY TO INSERT THE EQUIPMENT TO THE EQUIPMENTREQUEST TABLE
      $sql3 = "INSERT into action (requestID, deanAction, cdmoAction, lmoAction) values ('$requestID', '$dean', '$cdmo', '$lmo')";

      if (!mysql_query($sql3, $con))
      {
        die('Error: ' . mysql_error());
      }

      //QUERY TO INSERT THE EQUIPMENT TO THE EQUIPMENTREQUEST TABLE
      for($ctr = 0; $ctr < count($arrayEquipment); $ctr++)
      {
        $sql4 = "INSERT into equipmentrequest (requestID, ename, qty) values ('$requestID', '$arrayEquipment[$ctr]', '$arrayQty[$ctr]')";

        if (!mysql_query($sql4, $con))
        {
          die('Error: ' . mysql_error());
        }
      }

      //QUERY TO INSERT THE REQUEST TO THE NOTIFICATION TABLE
      $sql4 = "INSERT into notification values ('$requestID', 'dean', '0')";

      if (!mysql_query($sql4, $con))
      {
        die('Error: ' . mysql_error());
      }
      
      echo "<script language='javascript'>alert('Request Successful! Redirecting you back to main page.');</script>";
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
    }


  }
  else
  {
    //header('Location: http://localhost/mclrrs/main.php');
    header("location:main.php");
  }

 ?>