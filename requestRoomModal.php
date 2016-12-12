<!-- THIS IS USED TO INSERT REQUEST DETAILS INTO THE DATABASE -->
<!-- ANDITO DIN UNG PAGKUHA NG MGA VALUES FROM EQUIPMENT -->

<?php 
include('connects.php');
include_once('log-auth.php');
include('qConn.php');

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

        $query = EquipmentRequests($con,$equipment);

        if(mysqli_num_rows($query)>0)
        {
          while($row = mysqli_fetch_array($query))
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
    $sql1 = InsertRequestDetails($con,$username,$dept,$currentdate,$purpose,$dateofuse,$fromTime,$toTime,$room);

    if (!mysqli_query($con,$sql1))
    {
      die('Error: ' . mysqli_error());
    }
    else
    {
      GetLatestID($con,$username,$requestID,$dean,$cdmo,$lmo);

      //QUERY TO INSERT THE EQUIPMENT TO THE EQUIPMENTREQUEST TABLE
      for($ctr = 0; $ctr < count($arrayEquipment); $ctr++)
      {
        
        $sql4 = InsertEquipRequests($con,$requestID,$arrayEquipment[$ctr],$arrayQty[$ctr]);

        if (!mysqli_query($con,$sql4))
        {
          die('Error: ' . mysqli_error());
        }
      }
     // echo $requestID;
      //QUERY TO INSERT THE REQUEST TO THE NOTIFICATION TABLE
      //InsertNotifications($con,$requestID);
      //$sql5 = "INSERT into notification values ('$requestID', 'dean', '0')";
      
      echo "<script language='javascript'>alert('Request Successful! Redirecting you back to main page.');</script>";
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
    }


  }
  else
  {
    header("location:main.php");
  }

 ?>