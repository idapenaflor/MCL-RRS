<?php
	include('connects.php');
	include('log-auth.php');
	include('qConn.php');

	$day = "";
	$room = array();

	$query1 = SelectRoomID($con);

	if(mysqli_num_rows($query1) > 0)
    {
        while($row = mysqli_fetch_array($query1))
        {
           $room[] = $row['rID'];
        }
    }

	 for ($x = 0 ; $x < 7; $x++)
	 {
		 switch($x)
		 {
		 case 0: $day="Monday"; break;
		 case 1: $day="Tuesday"; break;
		 case 2: $day="Wednesday"; break;
		 case 3: $day="Thursday"; break;
		 case 4: $day="Friday"; break;
		 case 5: $day="Saturday"; break;
		 case 6: $day="Sunday"; break;
		 }
		 for ($y = 1 ; $y <= 9 ; $y++)
		 {
			 for ($z = 0 ; $z < count($room) ; $z++)
			 {
				 $sql1=SchedValues($con,$y,$day,$room[$z]);

				if (!mysqli_query($con,$sql1))
				{
					die('Error: ' . mysqli_error());
				}
			}
		 }
	 }

	 mysql_close($con);
?>